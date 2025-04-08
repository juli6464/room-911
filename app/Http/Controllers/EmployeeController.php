<?php

namespace App\Http\Controllers;

use App\Imports\EmployeesImport;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\AccessLog;
use App\Models\AdminUser;
use App\Models\Department;
use Barryvdh\DomPDF\Facades\Pdf;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller {
    // public function index() {
    //     return response()->json(Employee::all());
    // }
    public function index()
    {
        $employees = Employee::withCount('accessLogs')->get(); // agrega "access_logs_count"

        // Si quieres mantener el nombre 'access_attempts'
        $employees->each(function ($emp) {
            $emp->access_attempts = $emp->access_logs_count;
        });

        return response()->json($employees);
    }
    public function create() {
        return view('employees.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'department_id' => 'required|integer',
            'internal_id' => 'required|string',
            'access_granted' => 'required|boolean',
        ]);

        $employee = Employee::create($request->all());

        return response()->json($employee, 201);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'department_id' => 'required|integer',
            'internal_id' => 'required|string',
            'access_granted' => 'required|boolean',
        ]);

        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $employee->update($request->all());

        return response()->json($employee, 200);
    }
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $employee->delete();

        return response()->json(['message' => 'Employee deleted'], 200);
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx',
        ]);

        Excel::import(new EmployeesImport, $request->file('file'));

        return response()->json(['message' => 'Import successful']);
    }

    public function loginEmployee(Request $request)
    {
        $request->validate([
            'internal_id' => 'required|string',
        ]);

        $employee = Employee::where('internal_id', $request->internal_id)->first();

        // attempts
        AccessLog::create([
            'employee_id' => $employee ? $employee->id : null,
            'status' => $employee ? 'success' : 'fail',
            'attempt_time' => Carbon::now(),
        ]);

        if ($employee) {
            return response()->json([
                'message' => 'Login successful',
                'employee' => $employee,
            ]);
        } else {
            return response()->json(['message' => 'Invalid internal ID'], 401);
        }

    }
    public function show($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json([
            'employee' => $employee
        ]);
    }

}
