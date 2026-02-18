<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class EmailChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $newEmail;

    public function __construct(User $user, $newEmail)
    {
        $this->user = $user;
        $this->newEmail = $newEmail;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Address Changed - ACC Scheduling System',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.email-changed',
        );
    }
}
