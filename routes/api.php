<?php

use App\Http\Controllers\AccessLogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/employees/{id}', [EmployeeController::class, 'show']);
Route::post('/employees', [EmployeeController::class, 'store']);
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);
Route::put('/employees/{id}', [EmployeeController::class, 'update']);
Route::post('/import-excel-employees', [EmployeeController::class, 'import']);
Route::post('/employee-login', [EmployeeController::class, 'loginEmployee']);
Route::get('/access-logs/employees/{employeeId}', [AccessLogController::class, 'showByEmployee']);
Route::get('/employees/{id}/access-history', [EmployeeController::class, 'accessHistory']);
Route::post('/admin-users', [AdminController::class, 'store']);
