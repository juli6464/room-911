<?php

namespace App\Http\Controllers;

use App\Imports\EmployeesImport;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\AccessLog;
use App\Models\AdminUser;
use App\Models\Department;
use Barryvdh\DomPDF\Facades\Pdf;
use Maatwebsite\Excel\Facades\Excel;

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

}
