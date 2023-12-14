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
        $editor = User::create([
            'username' => 'editor',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'password' => 'editorpass',
            'active' => true,
        ]);

        $editor->assignRole('editor');

        $writer = User::create([
            'username' => 'writer',
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'password' => 'writerpass',
            'active' => true,
        ]);

        $writer->assignRole('writer');
    }
}
