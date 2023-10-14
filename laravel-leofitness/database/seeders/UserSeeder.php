<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Bouncer;

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
            'name' => 'manager',
            'email' => 'julieta@leofitness.in',
            'password' => bcrypt('password'),
            'status' => '1',
        ]);

        $admin = Bouncer::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);
        
        $adminAbilities = Bouncer::ability()->firstOrCreate([
            'name' => 'manage-gymie',
            'title' => 'super admin',
        ]);
        
        Bouncer::allow($admin)->to($adminAbilities);

        $user = User::first();
        Bouncer::assign('admin')->to($user);
    }
}
