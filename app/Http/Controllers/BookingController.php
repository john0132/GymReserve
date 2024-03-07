<?php

namespace App\Http\Controllers;

use App\Models\ScheduledClass;
use Faker\Guesser\Name;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // viewing the booking form for members
    public function create(){
     //loading all available bookings that are still ahead of this moment starting from the oldest one
        $scheduledClasses = ScheduledClass::upcoming()
        ->with('classType','instructor') //eager loading so it to avoid n+1 relationship query problem
        -> notBooked()
        ->oldest('date_time')->get();
        return view('member.book')->with('scheduledClasses',$scheduledClasses);
    }

    public function store(Request $request){
        auth()->user()->bookings()->attach($request->scheduled_class_id);

        return redirect()->route('booking.index');
    }

    public function index(){
        //load all currunt bookings that will still come in the future 
        $bookings = auth()->user()->bookings()->upcoming()->get();
        return view('member.upcoming')->with('bookings',$bookings);
    }

    public function destroy(int $id){
        auth()->user()->bookings()->detach($id);

        return redirect()->route('booking.index');
    }
}
