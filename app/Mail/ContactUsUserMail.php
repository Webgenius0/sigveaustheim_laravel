<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;

    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    public function build()
    {
        return $this->subject('Thank you for contacting us!')
            ->view('emails.contact.user')
            ->with(['contact' => $this->contact]);
    }
}
