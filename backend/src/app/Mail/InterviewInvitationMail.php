<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Application;

class InterviewInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $link;
    public $schedule;

    public function __construct(Application $application, $link = null, $schedule = null)
    {
        $this->application = $application;
        $this->link = $link;
        $this->schedule = $schedule;

        
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Undangan Interview - Winnicode Garuda Teknologi',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.interview',
            with: [
                'applicant' => $this->application,
                'link' => $this->link,
                'schedule' => $this->schedule,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}