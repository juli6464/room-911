<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\AccessLog;
use App\Models\AdminUser;
use App\Models\Department;
use Barryvdh\DomPDF\Facades\Pdf;

class EmployeeController extends Controller {
    public function index() {
        // $employees = Employee::all();
        // return view('employees.index', compact('employees'));
        return response()->json(Employee::all());
    }
    public function create() {
        return view('employees.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'department_id' => 'required|integer'
        ]);

        $employee = Employee::create($request->all());

        return response()->json($employee, 201);
    }
    public function importCsv(Request $request) {
        //improtar csv
    }
}
