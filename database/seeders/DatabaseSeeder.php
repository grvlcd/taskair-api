<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'test@test.com',
            'password' => bcrypt('password')
        ]);

        User::factory()->create([
            'name' => 'Christian Gonzales',
            'email' => 'mrcagonzales@gmail.com',
            'password' => bcrypt('password')
        ]);
    }
}
