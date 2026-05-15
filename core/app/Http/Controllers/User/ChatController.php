<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Chat;
use App\Models\JobBid;
use App\Rules\FileTypeValidate;
use App\Events\SendMessageToChat;
use App\Lib\PusherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'id'      => 'required',
            'type'    => 'required|in:service,job',
            'message' => 'required_without:file|string|nullable',
            'file'    => ['nullable', new FileTypeValidate(['jpg', 'jpeg', 'png', 'pdf']), 'max:2000'],
        ], [
            'message.required_without' => 'Please provide a message or attach a file.',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $user = Auth::user();
        $bookingId = 0;
        $jobBidId = 0;
        $file = null;



        if ($request->type == 'service') {
            $data = Booking::paid()->where('id', decrypt($request->id))
                ->where('service_id', '!=', 0)
                ->where(function ($query) use ($user) {
                    $query->where('seller_id', $user->id)
                        ->orWhere('buyer_id', $user->id);
                })
                ->first();

            if (!$data) {
                return response()->json(['error' => 'Booking not found or you are not authorized to access it.'], 404);
            }

            $bookingId = $data->id;
        } else {
            $data = JobBid::where('id', decrypt($request->id))
                ->where(function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->orWhere('buyer_id', $user->id);
                })
                ->first();

            if (!$data) {
                return response()->json(['error' => 'Job bid not found or you are not authorized to access it.'], 404);
            }

            $jobBidId = $data->id;
        }

        if ($request->hasFile('file')) {
            $file = fileUploader($request->file, getFilePath('chatFile'));
        }

        // Save the chat message
        $chat = new Chat();
        $chat->booking_id = $bookingId;
        $chat->job_bid_id = $jobBidId;
        $chat->user_id = $user->id;
        $chat->message = @$request->message ?? '';
        $chat->file = $file;
        $chat->save();

        // Determine the receiver
        $receiver = $data->buyer_id == $user->id ? $data->user : $data->buyer;

        $pusher = new PusherService();
        $result = $pusher->sendMessageToChat($request, $data, $user, $receiver, $chat);

        // Render the new chat message partial
        $chatHtml = view('Template::partials.single_chat_message', compact('chat', 'data'))->render();

        return response()->json(['html' => $chatHtml], 200);
    }


    // Method to handle AJAX chat refresh
    public function refresh(Request $request)
    {
        $request->validate([
            'id'   => 'required',
            'type' => 'required|in:service,job',
        ]);

        $user = Auth::user();
        $id = decrypt($request->id);

        if ($request->type == 'service') {
            $details = Booking::paid()->with(['seller', 'buyer'])
                ->where('id', $id)
                ->where('service_id', '!=', 0)
                ->where(function ($query) use ($user) {
                    $query->where('seller_id', $user->id)
                        ->orWhere('buyer_id', $user->id);
                })
                ->first();

            if (!$details) {
                return response()->json(['error' => 'Booking not found or you are not authorized to access it.'], 404);
            }

            $chats = Chat::where('booking_id', $details->id)
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            $details = JobBid::with(['user', 'buyer'])
                ->where('id', $id)
                ->where(function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->orWhere('buyer_id', $user->id);
                })
                ->first();

            if (!$details) {
                return response()->json(['error' => 'Job bid not found or you are not authorized to access it.'], 404);
            }

            $chats = Chat::where('job_bid_id', $details->id)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        // Render the chat thread partial
        $chatHtml = view('Template::partials.chat_thread', compact('chats', 'details'))->render();

        return response()->json(['html' => $chatHtml], 200);
    }
}
