<?php

namespace Database\Seeders;

use App\Models\ClassType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClassType::create([
            'name'=> 'TailwindCSS',
            'description'=> fake()->text(),
            'minutes' => 60
        ]);

        ClassType::create([
            'name'=> 'Vue.js',
            'description'=> fake()->text(),
            'minutes' => 90
        ]);
        ClassType::create([
            'name'=> 'Laravel',
            'description'=> fake()->text(),
            'minutes' => 120
        ]);
        ClassType::create([
            'name'=> 'Github',
            'description'=> fake()->text(),
            'minutes' => 20
        ]);
    }
}
