<?php
namespace App\Events;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
// 1
class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $sender, $receiver;
    // 2
    public function __construct($sender, $receiver)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
    }
    // 3
    public function broadcastWith()
    {
        return [
            'sender' => $this->sender,
            'receiver' => $this->receiver,
        ];
    }
    // 4
    public function broadcastAs()
    {
        return 'message.new';
    }
    // 5
    public function broadcastOn()
    {
        return new Channel('chat-channel');
    }
}
