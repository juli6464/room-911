<?php

namespace App\Http\Controllers;

use App\Imports\EmployeesImport;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\AccessLog;
use App\Models\AdminUser;
use App\Models\Department;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\Facades\Pdf;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller {

    public function index()
    {
        $employees = Employee::with(['accessLogs' => function ($query) {
            $query->latest();
        }])->get();

        $employees = $employees->map(function ($employee) {
            $attemptTime = optional($employee->accessLogs->first())->attempt_time;
            $empArray = $employee->toArray(); // convierte a array
            $empArray['attempt_time'] = $attemptTime;
            return $empArray;
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
        if ($request->hasFile('file')) {
            Excel::import(new EmployeesImport, $request->file('file'));
            return response()->json(['success' => true, 'message' => 'Archivo importado correctamente']);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function loginEmployee(Request $request)
    {
        $request->validate([
            'internal_id' => 'required|string',
        ]);

        $employee = Employee::where('internal_id', $request->internal_id)->first();
        // if employe dont have permissions failed
        $status = 'failed';
            if ($employee && $employee->access_granted == 1) {
                $status = 'success';
        }

        // attempts
        AccessLog::create([
            'employee_id' => $employee ? $employee->id : null,
            'status' => $status,
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
    public function accessHistory($id)
    {
        $history = AccessLog::where('employee_id', $id)->orderBy('attempt_time', 'desc')->get();
        return response()->json($history);
    }

}
