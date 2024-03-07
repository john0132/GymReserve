<?php

namespace App\Listeners;

use App\Events\ClassCancled;
use App\Jobs\NotifyCancledJob;
use App\Mail\ClassCancledMail;
use App\Notifications\ClassCancledNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class NotifyClassCancled
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
    public function handle(ClassCancled $event): void
    {

        $members= $event->scheduledClass->members()->get();
        $className = $event->scheduledClass->classType->name;
        $classDate_time = $event->scheduledClass->date_time;
        $details = compact('className','classDate_time');
        
        // $members->each(function($user) use ($details){
        //     Mail::to($user)->send(new ClassCancledMail($details));
        // });
        
        NotifyCancledJob::dispatch($members,$details);
    }
}
