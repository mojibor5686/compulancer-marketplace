<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InboxChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $sender;
    public $receiver;
    public $attachment;
    public $uniqueId;
    public $createdAt;
    public $chatFileName;

    /**
     * Create a new event instance.
     *
     * @param array $data
     * @param string $type
     */
    public function __construct($data)
    {
        $this->message = $data['message'];
        $this->sender = [
            'id'    => @$data['sender']->id,
            'name'  => @$data['sender']->username ?? 'System',
            'image' => @$data['sender']->id ? getImage(getFilePath('userProfile') . '/' . (@$data['sender']->image ?? 'default.png'), isAvatar: true) : siteFavicon(),
        ];
        $this->receiver = [
            'id'        => @$data['receiver']->id,
            'name'      => @$data['receiver']->username ?? 'System',
        ];
        $this->attachment   = $data['attachment'];
        $this->uniqueId     = $data['uniqueId'];
        $this->createdAt    = $data['createdAt'];
        $this->chatFileName = $data['chatFileName'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('inbox-channel.' . $this->uniqueId);
    }

    /**
     * Get the event name to broadcast as.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'chat-message';
    }
}
