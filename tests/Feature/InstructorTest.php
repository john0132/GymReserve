<?php

namespace Tests\Feature;

use App\Models\ClassType;
use App\Models\ScheduledClass;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\ClassTypeSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InstructorTest extends TestCase
{

    use RefreshDatabase;
    
    public function test_instructor_is_directed_to_instrucotr_dashboard(){
    $user = User::factory()->create([
        'role'=>'instructor'
    ]);

    $response = $this->actingAs($user)
    ->get('/dashboard');

    $response->assertRedirectToRoute('instructor.dashboard');

    $this->followRedirects($response)->assertSeeText("Hey instructor");
}

public function test_instructor_can_schedule_a_class(){

    //given
    $user = User::factory()->create([
        'role'=>'instructor'
    ]);

    $this->seed(ClassTypeSeeder::class);

    //where
    $response = $this->actingAs($user)
    ->post('/instructor/schedule',[
        'class_type_id' => ClassType::first()->id ,
        'date' => '2024-04-20',
        'time' => '09:00:00'

]);
//then
$this->assertDatabaseHas('scheduled_classes',[
    'class_type_id' => ClassType::first()->id ,
    'date_time' => '2024-04-20 09:00:00'
]);
$response-> assertRedirectToRoute('schedule.index');
}

public function test_instructor_can_delete_a_class(){
    //Given
    $user = User::factory()->create([
        'role'=>'instructor'
    ]);

    $this->seed(ClassTypeSeeder::class);

    $schedluedClass = ScheduledClass::create([
        'instructor_id'=> $user->id,
        'class_type_id' => ClassType::first()->id,
        'date_time' => '2024-04-20 09:00:00'
    ]);

    //When 
    $response = $this->actingAs($user)->delete('/instructor/schedule/'.$schedluedClass->id);
    //Then

    $this->assertDatabaseMissing('scheduled_classes',[
        'id'=> $user->id
    ]);
}

public function test_cannot_cancel_class_with_less_than_2_hours_left(){
 //Given
 $user = User::factory()->create([
    'role'=>'instructor'
]);

$this->seed(ClassTypeSeeder::class);

$schedluedClass = ScheduledClass::create([
    'instructor_id'=> $user->id,
    'class_type_id' => ClassType::first()->id,
    'date_time' => now()->addHours(1)->minutes(0)->seconds(0)
]);
    //when 
    $response = $this->actingAs($user)
    ->get('instructor/schedule');

    $response->assertDontSee('Cancel');
    $response = $this->actingAs($user)->delete('/instructor/schedule/'.$schedluedClass->id);

    //then 

    $this->assertDatabaseHas('scheduled_classes',[
        'id'=>$schedluedClass->id
    
    ]);
}
}
