<?php

namespace App\Mail;

use App\Models\Webserver;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ServerUnhealthyMail extends Mailable
{
    use Queueable, SerializesModels;

    protected Webserver $webserver;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Webserver $webserver)
    {
        $this->webserver = $webserver;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Server Unhealthy',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.server_unhealthy',
            with: [
                'serverName' => $this->webserver->name,
                'url'        => $this->webserver->url,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
