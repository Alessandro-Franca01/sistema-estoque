<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class UserRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Public data available to the mail view
     * @var array
     */
    public array $data;

    /**
     * Create a new message instance.
     *
     * @param array $data Expected keys: name, email (and optional others)
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name');

        return new Envelope(
            from: $fromAddress ? new Address($fromAddress, $fromName) : null,
            subject: 'Bem-vindo ao Sistema',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.users-register',
            with: [
                'data' => $this->data,
                'url' => URL::temporarySignedRoute(
                    'register.email',
                    now()->addMinutes(1440),
                    [
                        'perfil' => $this->data['role'],
                        'email' => $this->data['email'],
                        'department_id' => $this->data['department_id']
                    ]
                )
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
