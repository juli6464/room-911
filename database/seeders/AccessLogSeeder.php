<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccessLogSeeder extends Seeder {
    public function run() {
        \App\Models\AccessLog::insert([
            ['employee_id' => 1, 'status' => 'success', 'attempt_time' => now()],
            ['employee_id' => 2, 'status' => 'failed', 'attempt_time' => now()]
        ]);
    }
}
