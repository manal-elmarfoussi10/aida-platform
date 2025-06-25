<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['Admin', 'Facility Manager', 'User'];
        $plans = ['basic', 'pro'];

        foreach ($roles as $role) {
            foreach ($plans as $plan) {
                User::create([
                    'name' => "$role ($plan)",
                    'email' => strtolower(str_replace(' ', '_', $role) . '_' . $plan) . '@aida.test',
                    'password' => Hash::make('password'),
                    'role' => $role,
                    'plan' => $plan,
                ]);
            }
        }
    }
}