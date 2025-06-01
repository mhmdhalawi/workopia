<?php

namespace App\Mail;

use App\Models\Applicant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class JobApplied extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The applicant instance.
     *
     * @var Applicant
     */


    /**
     * Create a new message instance.
     */
    public function __construct(public Applicant $applicant) {}


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email received',
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: "
                <p>Dear {$this->applicant->full_name},</p>
                <p>Thank you for applying for the job: <strong>{$this->applicant->job->title}</strong>.</p>
                <p>We will review your application and get back to you soon.</p>
                <p>Best regards,</p>
                <p>The Hiring Team</p>"
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if ($this->applicant->resume_file_path) {
            return [
                Attachment::fromPath(storage_path('app/public/' . $this->applicant->resume_file_path))
                    ->as('resume.pdf')
                    ->withMime('application/pdf'),
            ];
        }
        return [];
    }
}
