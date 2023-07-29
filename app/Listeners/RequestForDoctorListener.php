<?php

namespace App\Listeners;

use App\Events\RequestForDoctor;
use App\Notifications\NewEmailNotification;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RequestForDoctorListener
{
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
    public function handle(RequestForDoctor $event): void
    {


        $doctor = $event->doctor;
        $details = [
            'view'=>"notifyForDoctor",
            'content'=>[
            'title' => 'Mail from ahmed.com',
            'body' => 'This is for testing email using smtp'
        ],
            'subject' => 'test'
        ];
        try{

            $doctor->notify(new NewEmailNotification($details));
        }catch(Exception $e) {

            dd($e);
        }
    }
}
