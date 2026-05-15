<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessageToChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $type;
    public $message;
    public $sender;
    public $receiver;
    public $attachment;
    public $remark;
    public $itemId;
    public $createdAt;
    public $chatFileName;
    /**
     * Create a new event instance.
     *
     * @param string $type
     * @param object $sender
     * @param object $receiver
     * @param string $message
     * @param string|null $attachment
     * @param int $itemId
     */
    public function __construct($type, $sender, $receiver, $message, $attachment = null, $itemId, $chatFileName = null)
    {
        $this->remark  = 'chat-message';
        $this->type    = $type;
        $this->message = $message;
        $this->sender  = [
            'id'    => @$sender->id,
            'name'  => @$sender->username ?? 'System',
            'image' => @$sender->id ? getImage(getFilePath('userProfile') . '/' . (@$sender->image ?? 'default.png'), isAvatar: true) : siteFavicon(),
        ];
        $this->receiver = [
            'id'   => @$receiver->id,
            'name' => @$receiver->username ?? 'System',
        ];
        $this->attachment = $attachment;
        $this->itemId     = $itemId;
        $this->createdAt  = now()->format('Y-m-d h:i A');
        $this->chatFileName = $chatFileName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat-channel.' . $this->type);
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
