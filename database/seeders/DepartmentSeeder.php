<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder {
    public function run() {
        \App\Models\Department::insert([
            ['name' => 'Departament 1'],
            ['name' => 'Departament 2']
        ]);
    }
}
