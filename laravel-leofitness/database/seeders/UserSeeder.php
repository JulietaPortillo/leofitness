<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin
        User::create([
            'name' => 'leofitness',
            'email' => 'admin@leofitness.in',
            'password' => bcrypt('password'),
            'status' => '1',
        ]);
        
        // Create manager
        User::create([
            'name' => 'Julieta',
            'email' => 'julieta@leofitness.in',
            'password' => bcrypt('password'),
            'status' => '1',
        ]);
    }
}
