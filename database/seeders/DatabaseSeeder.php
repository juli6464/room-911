<?php

use Database\Seeders\AccessLogSeeder;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\EmployeeSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run() {
        $this->call([
            DepartmentSeeder::class,
            EmployeeSeeder::class,
            AdminUserSeeder::class,
            AccessLogSeeder::class,
        ]);
    }
}
