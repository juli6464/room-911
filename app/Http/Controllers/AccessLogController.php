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
    public function simulateAccess(Request $request) {
        $employee = Employee::where('internal_id', $request->input('internal_id'))->first();
        AccessLog::create([
            'employee_id' => $employee->id ?? null,
            'status' => $employee ? 'success' : 'failed',
            'attempt_time' => now()
        ]);
        return response()->json(['message' => $employee ? 'Access Granted' : 'Access Denied']);
    }
}
