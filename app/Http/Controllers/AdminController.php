<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller {
    public function index() {
        return view('dashboard');
    }
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:admin_users',
            'password' => 'required|string|min:6',
        ]);

        $adminUser = AdminUser::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Admin user created', 'adminUser' => $adminUser], 201);
    }
}
