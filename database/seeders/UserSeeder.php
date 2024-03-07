<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        User::factory()->create([
            'name' => 'Hamada',
            'email'=> 'Hamada@gmail.com',
             'password' => bcrypt('11111111')
        ]);
        User::factory()->create([
            'name' => 'Essam',
            'email'=> 'Essam@gmail.com',
             'password' => bcrypt('11111111')
        ]);

        User::factory()->create([
            'name' => 'John',
            'email'=> 'John@gmail.com',
            'role' => 'instructor',
             'password' => bcrypt('11111111')
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email'=> 'Admin@gmail.com',
            'role' => 'admin',
             'password' => bcrypt('11111111')
        ]);
        User::factory()->count(10)->create();
        User::factory()->count(10)->create([
            'role' => 'instructor'
        ]);
    }
}
