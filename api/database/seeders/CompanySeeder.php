<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            ['logo' => 'https://1000logos.net/wp-content/uploads/2016/10/Apple-Logo.png', 'name' => 'Apple Inc', 'status' => true],
            ['logo' => 'https://1000logos.net/wp-content/uploads/2017/06/Samsung-emblem.png', 'name' => 'Samsung Electronics Co. Ltd.', 'status' => true],
            ['logo' => 'https://assets-global.website-files.com/5ee732bebd9839b494ff27cd/5eef3a3260847d0d2783a76d_Microsoft-Logo-PNG-Transparent-Image.png', 'name' => 'Microsoft Corp.', 'status' => true],
            ['logo' => 'https://1000logos.net/wp-content/uploads/2021/05/Sony-logo.png', 'name' => 'Sony Corp.', 'status' => true],
            ['logo' => 'https://1000logos.net/wp-content/uploads/2021/05/Intel-logo.png', 'name' => 'Intel Corp.', 'status' => true],
        ];

        foreach ($companies as $com) {
            Company::create([
                'name' => $com['name'],
                'logo' => $com['logo'],
                'status' => $com['status'],
            ]);
        }
    }
}
