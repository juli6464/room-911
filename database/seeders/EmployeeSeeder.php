<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder {
    public function run() {
        \App\Models\Employee::insert([
            ['internal_id' => 'EMP001', 'name' => 'John', 'last_name' => 'Doe', 'department_id' => 1, 'access_granted' => true],
            ['internal_id' => 'EMP002', 'name' => 'Jihn', 'last_name' => 'Doi', 'department_id' => 2, 'access_granted' => false]
        ]);
    }
}
