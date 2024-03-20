<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            "name" => "Admin",
            "username" => "adminracik",
            "no_hp" => "081234567891",
            'password' => Hash::make('password'),
            "role_id" => 1,
        ]);
    }
}
