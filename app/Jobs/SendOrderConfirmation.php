<?php

namespace App\Jobs;

use App\Mail\OrderConfirmation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class SendOrderConfirmation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    public $products;

    /**
     * Create a new job instance.
     */
    public function __construct($order,$products)
    {
        $this->order = $order;
        $this->products = $products;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->order['email'])->send(new OrderConfirmation($this->order,$this->products));
    }
}
