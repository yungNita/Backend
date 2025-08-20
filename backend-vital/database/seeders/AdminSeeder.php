<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'Super Admin',
            'company_id' => 'Admin@0001',
            'password' => Hash::make('Admin@12345'),
            'role' => 'admin',
        ]);


        
    }
}
