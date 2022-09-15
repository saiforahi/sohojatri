<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyOTP extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $verification_code;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verification_code,$name)
    {
        //
        $this->verification_code = $verification_code;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('OTP Verification')->view('email.verify');
    }
}
