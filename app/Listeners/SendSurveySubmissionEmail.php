<?php

namespace App\Listeners;

use App\Events\SurveySubmitEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendSurveySubmissionEmail
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param SurveySubmitEvent $event
     * @return void
     */

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SurveySubmitEvent $event)
    {
        //dd($event);
        // Send email with survey submission details
        Mail::to($event->email)->send(new \App\Mail\SurveySubmission($event->email,$event->name, $event->phone_number, $event->date_of_birth, $event->gender));
    }
}
