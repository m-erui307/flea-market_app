<?php

namespace App\Mail;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $purchase;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Product $product, Purchase $purchase)
    {
        $this->product = $product;
        $this->purchase = $purchase;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('取引が完了しました')
            ->view('email_completed');
    }
}
