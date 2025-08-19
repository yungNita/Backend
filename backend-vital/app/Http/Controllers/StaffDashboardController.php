<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        return response()->json([
            'message' => 'Welcome to Staff Dashboard',
            'user' => $request->user()
        ]);
    }
}
