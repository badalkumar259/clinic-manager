<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Clinician']);

        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@clinic.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role_id' => 1
        ]);
    }
}
