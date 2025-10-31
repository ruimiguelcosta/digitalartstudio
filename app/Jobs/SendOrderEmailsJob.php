<?php

namespace App\Jobs;

use App\Mail\OrderConfirmationEmail;
use App\Mail\OrderNotificationEmail;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendOrderEmailsJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order
    ) {}

    public function handle(): void
    {
        Mail::to($this->order->customer_email)
            ->send(new OrderConfirmationEmail($this->order));

        Mail::to('digitalartstudio.pt@gmail.com')
            ->send(new OrderNotificationEmail($this->order));
    }
}
