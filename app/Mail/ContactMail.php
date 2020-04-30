<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailFrom;
    public $name;
    public $emailSubject;
    public $text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $from, string $name, string $subject, string $text)
    {
        $this->name = $name;
        $this->emailFrom = $from;
        $this->emailSubject = $subject;
        $this->text = $text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from($this->emailFrom, $this->name)
            ->subject($this->emailSubject)
            ->view('emails.contact.index', [ "message" => $this->text ]);
    }
}
