<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public $products;
    public $price_ship;

    public function __construct($order,$products,$price_ship)
    {
        $this->order = $order;
        $this->products = $products;
        $this->price_ship = $price_ship;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thông báo mua hàng thành công',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.mails.send_order_mail',
            with: [
                'data' => $this->order,
                'products' => $this->products,
                'service_fee' => $this->price_ship,
                ],
        );
    }

    public function build()
    {
        $email = $this->view('admin.mails.send_order_mail')
            ->subject('Thông báo mua hàng thành công')
            ->with([
                'data' => $this->order,
                'products' => $this->products,
                'service_fee' => $this->price_ship,
            ]);

        foreach ($this->products as $product) {
            $pathToImage = public_path('path/to/your/images/' . $product->image); // Assuming you have an 'image' attribute for each product

            if (file_exists($pathToImage)) {
                $email->attach($pathToImage, [
                    'as' => $product->name . '.jpg',
                    'mime' => 'image/jpeg',
                ]);
            }
        }

        return $email;
    }
}
