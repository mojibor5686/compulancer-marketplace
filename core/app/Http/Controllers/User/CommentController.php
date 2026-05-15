<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Job;
use App\Models\Reply;
use App\Models\Service;
use App\Models\Software;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function commentStore(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|gt:0',
            'type'       => 'required|in:service,software,job',
            'comment'    => 'required',
        ]);

        $serviceId  = 0;
        $softwareId = 0;
        $jobId      = 0;

        $commentQuery = Comment::query();

        if ($request->type == 'service') {
            $product   = Service::where('id', $request->product_id)->active()->userActiveCheck()->checkData()->firstOrFail();
            $serviceId = $product->id;
            $commentQuery = $commentQuery->where('service_id', $serviceId);
        } elseif ($request->type == 'software') {
            $product    = Software::where('id', $request->product_id)->active()->userActiveCheck()->checkData()->firstOrFail();
            $softwareId = $product->id;
            $commentQuery = $commentQuery->where('software_id', $softwareId);
        } else {
            $product = Job::where('id', $request->product_id)->active()->userActiveCheck()->checkData()->firstOrFail();
            $jobId   = $product->id;
            $commentQuery = $commentQuery->where('job_id', $jobId);
        }

        $comment = new Comment();
        $comment->user_id = auth()->id();
        $comment->service_id = $serviceId;
        $comment->software_id = $softwareId;
        $comment->job_id = $jobId;
        $comment->comment = $request->comment;
        $comment->save();

        // Fetch the partial view
        $html = view('Template::partials.comment_item', compact('comment'))->render();

        // Fetch the total comments count
        $totalComments = $commentQuery->count();

        return response()->json([
            'success'       => true,
            'message'       => 'Your Comment has been posted successfully.',
            'html'          => $html, // Include rendered partial view
            'totalComments' => $totalComments, // Include the total comments count
        ]);
    }

    public function replyStore(Request $request)
    {
        $request->validate([
            'comment_id' => 'required',
            'reply' => 'required',
        ]);

        $comment = Comment::where('id', decrypt($request->comment_id))->firstOrFail();

        $reply = new Reply();
        $reply->user_id = auth()->id();
        $reply->comment_id = $comment->id;
        $reply->reply = $request->reply;
        $reply->save();

        return response()->json([
            'success' => true,
            'message' => 'Your reply has been posted successfully.',
            'reply' => $reply->reply,
            'date' => $reply->created_at->format('d M Y'),
            'username' => auth()->user()->username,
            'userImage' => getImage(getFilePath('userProfile') . '/' . auth()->user()->image, isAvatar: true),
            'commentId' => $comment->id,
        ]);
    }
}
