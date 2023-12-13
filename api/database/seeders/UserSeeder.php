<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'editor',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'password' => 'password123',
            'active' => true,
        ]);
    }
}
