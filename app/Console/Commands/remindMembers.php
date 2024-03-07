<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\remindMembersNotifications;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class remindMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remind-members';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind members to book a call';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $members = User::where('role','member')
        ->whereDoesntHave('bookings',function($query){
            $query->where('date_time','>',now());
        })->select('name','email')->get();

        $this->table(
            ['Name','Email'],
            $members->toArray()
        );

        Notification::send($members,new remindMembersNotifications);
    }
}
