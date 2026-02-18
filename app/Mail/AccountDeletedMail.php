<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountDeletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $userEmail;
    public $deletedAt;

    public function __construct($userName, $userEmail)
    {
        $this->userName = $userName;
        $this->userEmail = $userEmail;
        $this->deletedAt = now();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Account Deleted - ACC Scheduling System',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.account-deleted',
        );
    }
}
