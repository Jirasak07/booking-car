<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mail extends Mailable
{
    use Queueable, SerializesModels;
/**
     * The order instance.
     *
     * @var \App\Models\Mail
     */
    public $data;
 
    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Mail  $order
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email from bookingcar')->view('email.email');
    }
}
