<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $mes;
    //mes = 1: Thông báo có tài khoản đăng nhập ở thiết bị khác
    //mes = 2: Đồng ý cho đăng nhập
    //mes = 3: Từ chối cho đăng nhập
    /**
     * Create a new event instance.
     */
    public function __construct($mes)
    {
        $this->mes=$mes;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('thongbao'),
        ];
    }
}
