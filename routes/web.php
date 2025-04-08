<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AccessLogController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas con middleware de autenticación
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // CRUD de empleados
    Route::get('/employees', [EmployeeController::class, 'index']);
    // Carga masiva de empleados
    Route::post('/employees/upload', [EmployeeController::class, 'importCsv'])->name('employees.import');

    // Exportar historial de accesos a PDF
    Route::get('/access-logs/pdf/{id}', [AccessLogController::class, 'exportPdf'])->name('access-logs.pdf');

    // Simulación de acceso
    Route::post('/simulate-access', [AccessLogController::class, 'simulateAccess'])->name('simulate-access');
});
