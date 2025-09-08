<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
            ]);
        }

        Setting::updateOrCreate(['key' => 'site_name'], ['value' => 'Boarding House Manager']);
        Setting::updateOrCreate(['key' => 'currency'], ['value' => 'USD']);
    }
}
