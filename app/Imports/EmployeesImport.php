<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Employee([
            'internal_id'   => $row['internal_id'],
            'name'          => $row['name'],
            'last_name'     => $row['last_name'],
            'department_id' => $row['department_id'],
            'access_granted'=> filter_var($row['access_granted'], FILTER_VALIDATE_BOOLEAN),
        ]);
    }
}
