<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Lib\PusherService;
use App\Models\Inbox;
use App\Models\Message;
use App\Models\User;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class InboxController extends Controller
{
public function messages($uniqueId = null)
{
    $pageTitle = 'Inbox Messages';
    
    $inboxes = Inbox::where('sender_id', auth()->id())
        ->orWhere('receiver_id', auth()->id())
        ->latest()
        ->with(['sender', 'receiver'])
        ->get();

    if (!$uniqueId && $inboxes->isNotEmpty()) {
        $uniqueId = $inboxes->first()->unique_id;
    }

    if (!$uniqueId) {
        $inbox = null;
        $messages = collect();
        $lastChatId = null;
        return view('Template::user.inbox.messages', compact('pageTitle', 'inboxes', 'inbox', 'messages', 'lastChatId'));
    }

    $inbox = Inbox::where('unique_id', $uniqueId)
        ->where(function ($q) {
            $q->where('sender_id', auth()->id())
                ->orWhere('receiver_id', auth()->id());
        })
        ->firstOrFail();

    if (request()->ajax()) {
        $lastChatId = request('last_chat_id');
        $messagesQuery = Message::where('inbox_id', $inbox->id)
            ->with(['sender', 'receiver'])
            ->latest();

        if ($lastChatId) {
            $messagesQuery->where('id', '<', $lastChatId);
        }

        $messages = $messagesQuery->take(10)->get();

        if ($messages->isEmpty()) {
            return response()->json(['last' => true]);
        }

        $view = view('Template::partials.chat_thread_inbox', compact('messages'))->render();

        return response()->json([
            'success' => true,
            'html' => $view,
        ]);
    }

    $messages = Message::where('inbox_id', $inbox->id)
        ->with(['sender', 'receiver'])
        ->latest()
        ->take(10)
        ->get();

    $lastChatId = $messages->last()->id ?? null;

    return view('Template::user.inbox.messages', compact('pageTitle', 'inboxes', 'inbox', 'messages', 'lastChatId'));
}

    public function create(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required',
            'subject'     => 'required|max:40',
            'message'     => 'required'
        ]);

        $receiver = User::findOrFail(decrypt($request->receiver_id));
        $senderId = auth()->id();

        if ($receiver->id == $senderId) {
            $notify[] = ['error', 'You cannot send a message to yourself.'];
            return back()->withNotify($notify);
        }

        $checkInbox = Inbox::where(function ($q) use ($senderId) {
            $q->where('sender_id', $senderId)
                ->orWhere('receiver_id', $senderId);
        })->where(function ($q) use ($receiver) {
            $q->where('sender_id', $receiver->id)
                ->orWhere('receiver_id', $receiver->id);
        })->first();

        if ($checkInbox) {
            $message              = new Message();
            $message->inbox_id    = $checkInbox->id;
            $message->sender_id   = $senderId;
            $message->receiver_id = $receiver->id;
            $message->message     = $request->message;
            $message->save();

            return redirect()->route('user.inbox.messages', $checkInbox->unique_id);
        }

        $inbox              = new Inbox();
        $inbox->unique_id   = getTrx();
        $inbox->subject     = $request->subject;
        $inbox->sender_id   = $senderId;
        $inbox->receiver_id = $receiver->id;
        $inbox->save();

        $message              = new Message();
        $message->inbox_id    = $inbox->id;
        $message->sender_id   = $senderId;
        $message->receiver_id = $receiver->id;
        $message->message     = $request->message;
        $message->save();

        $notify[] = ['success', 'Your message has been sent successfully'];
        return back()->withNotify($notify);
    }

    // New method for storing messages via Ajax
    public function storeMessage(Request $request)
    {
        $validator = validator($request->all(), [
            'unique_id'   => 'required',
            'receiver_id' => 'required',
            'message'     => 'required_without:file',
            'file'        => ['nullable', new FileTypeValidate(['jpg', 'jpeg', 'png', 'pdf']), 'max:2000'],
        ], [
            'message.required_without' => "The message field is required"
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $receiver = User::find(decrypt($request->receiver_id));
        if (!$receiver) {
            return response()->json(['error' => 'Receiver not found'], 404);
        }

        $senderId = auth()->id();

        if ($receiver->id == $senderId) {
            return response()->json(['error' => 'You cannot send a message to yourself.'], 400);
        }

        $inbox = Inbox::where('unique_id', $request->unique_id)
            ->where(function ($q) use ($senderId) {
                $q->where('sender_id', $senderId)
                    ->orWhere('receiver_id', $senderId);
            })
            ->first();

        if (!$inbox) {
            return response()->json(['error' => 'Conversation not found'], 404);
        }

        $file = null;
        if ($request->hasFile('file')) {
            $file = fileUploader($request->file, getFilePath('messageFile'));
        }

        $message              = new Message();
        $message->inbox_id    = $inbox->id;
        $message->sender_id   = $senderId;
        $message->receiver_id = $receiver->id;
        $message->message     = $request->message;
        $message->file        = $file;
        $message->save();

        $pusher = new PusherService();
        $result = $pusher->sendInboxMessage([
            'sender' => auth()->user(),
            'receiver' => $receiver,
            'message' => $request->message,
            'attachment' => $file ? route('file.download', [encrypt($file), 'messageFile']) : null,
            'chatFileName' => $file,
            'createdAt' => $message->created_at->format('Y-m-d H:i:s'),
            'uniqueId' => $inbox->unique_id
        ]);

        // Render the new message partial
        $messageHtml = view('Template::partials.single_message', compact('message'))->render();

        return response()->json(['html' => $messageHtml], 200);
    }


    // New method for refreshing messages via Ajax
    public function refreshMessages($uniqueId)
    {
        $inbox = Inbox::where('unique_id', $uniqueId)
            ->where(function ($q) {
                $q->where('sender_id', auth()->id())
                    ->orWhere('receiver_id', auth()->id());
            })
            ->first();

        if (!$inbox) {
            return response()->json(['error' => 'Conversation not found'], 404);
        }

        $messages = Message::where('inbox_id', $inbox->id)
            ->with(['sender', 'receiver'])
            ->get();

        $messagesHtml = view('Template::partials.chat_thread_inbox', compact('messages'))->render();

        return response()->json(['html' => $messagesHtml], 200);
    }
}
