<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder {
    public function run() {
        \App\Models\AdminUser::insert([
            ['username' => 'admin1', 'password' => Hash::make('password123')],
            ['username' => 'admin2', 'password' => Hash::make('password456')]
        ]);
    }
}
