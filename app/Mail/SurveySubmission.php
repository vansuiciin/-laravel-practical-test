<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SurveySubmission extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $phone_number;
    public $date_of_birth;
    public $gender;

    /**
     * Create a new message instance.
     *
     * @param $email
     * @param $name
     * @param $phone_number
     * @param $date_of_birth
     * @param $gender
     */

    /**
     * Create a new message instance.
     */
    public function __construct($email, $name, $phone_number, $date_of_birth, $gender)
    {
        $this->email = $email;
        $this->name = $name;
        $this->phone_number = $phone_number;
        $this->date_of_birth = $date_of_birth;
        $this->gender = $gender;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Survey Submission',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.survey_submission'
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
