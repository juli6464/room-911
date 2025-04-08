<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\AccessLog;
use App\Models\AdminUser;
use App\Models\Department;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
// use Barryvdh\DomPDF\Facades\Pdf;

class AccessLogController extends Controller {
    public function index() {
        $logs = AccessLog::all();
        return view('access_logs.index', compact('logs'));
    }
    public function exportPdf($id) {
        $employee = Employee::findOrFail($id);
        $logs = AccessLog::where('employee_id', $id)->get();
        $pdf = FacadePdf::loadView('access_logs.pdf', compact('employee', 'logs'));
        return $pdf->download('access_log.pdf');
    }
    public function showByEmployee($employeeId)
    {
        $employee = Employee::with('accessLogs')->findOrFail($employeeId);

        return response()->json([
            'employee' => $employee->only(['id', 'name', 'last_name', 'internal_id']),
            'access_attempts' => AccessLog::where('employee_id', $employee->id)->count(),
            'logs' => $employee->accessLogs,
        ]);
    }

}
