<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kebunkode.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('kebunkode2026'),
                'is_admin' => true,
            ]
        );
    }
}
