<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
     public function dashboard(Request $request)
    {
        return response()->json([
            'message' => 'Welcome to Admin Dashboard',
            'user' => $request->user()
        ]);
    }
}
