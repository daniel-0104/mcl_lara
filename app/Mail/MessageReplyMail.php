<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MessageReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $userMessage;
    public $name;
    public $formattedMessage;

    public function __construct($message,$formattedMessage,$name)
    {
        $this->userMessage = $message;
        $this->formattedMessage = $formattedMessage;
        $this->name = $name;
    }

    // public function build()
    // {
    //     return $this->view('emails.reply')
    //                 ->with([
    //                     'userMessage' => $this->userMessage,
    //                     'formattedMessage' => $this->formattedMessage,
    //                     'name' => $this->name
    //                 ]);
    // }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Message Reply Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reply',
        );
    }

    public function data(): array
    {
        return [
            'userMessage' => $this->userMessage,
            'formattedMessage' => $this->formattedMessage,
            'name' => $this->name,
        ];
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
