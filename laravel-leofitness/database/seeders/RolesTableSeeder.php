<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Roles
        $roles = [
            [
                'name'  =>  'Gymie',
            ],
            [
                'name'  =>  'Admin',
            ],
            [
                'name'  =>  'Manager',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
