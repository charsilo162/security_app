<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $email, $subjectText, $messageBody;

    public function __construct($name, $email, $subject, $messageBody)
    {
        $this->name = $name;
        $this->email = $email;
        $this->subjectText = $subject;
        $this->messageBody = $messageBody;
    }

    public function build()
    {
        return $this->subject($this->subjectText)
                    ->from($this->email, $this->name)
                    ->html($this->messageBody);
    }
}
