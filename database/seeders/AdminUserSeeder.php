<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run()
{
    User::create([
        'name' => 'Admin User',
        'email' => 'admin@medbooker.com',
        'phone' => '+1234567890',
        'password' => Hash::make('SecurePassword123!'),
        'role' => 'admin'
    ]);
}
}

