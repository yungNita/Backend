<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\PostJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ApplicationController extends Controller
{
    // Fetch positions for dropdown with optional search
    public function getPositions(Request $request)
    {
        $search = $request->input('q', ''); // search query, default empty

        $positions = PostJob::where('status', 'open') // only currently hiring
            ->where('title', 'like', "%{$search}%") // searchable
            ->get(['id', 'title']);

        return response()->json($positions);
    }

    // Store application
    public function store(Request $request)
{
    $validated = $request->validate([
        'fullname' => 'required|string',
        'position_name' => 'required|string',
        'ph_num' => 'required|string',
        'email' => 'required|email',
        'cv_file' => 'required|file|mimes:pdf,doc,docx',
        'remark' => 'nullable|string',
        'department' => 'nullable|string',
        'company' => 'nullable|string',
        'other_file' => 'nullable|file|mimes:pdf,doc,docx',
    ]);

    $application = Application::create([
        'fullname' => $validated['fullname'],
        'position_name' => $validated['position_name'],
        'ph_num' => $validated['ph_num'],
        'email' => $validated['email'],
        'cv_file' => $request->file('cv_file')->store('cvs', 'public'),
        'remark' => $validated['remark'] ?? null,
        'department' => $validated['department'] ?? null,
        'company' => $validated['company'] ?? null,
        'other_file' => $request->file('other_file') ? $request->file('other_file')->store('other_files', 'public') : null,
        'date_applied' => now(),
    ]);

    return response()->json(['success' => true, 'application' => $application]);
}


    // Get all application list
    public function index()
    {
        $applications = Application::all();
        return response()->json($applications);
    }


    // Update application status by admin
    public function updateStatus(Request $request, $id)
    {
        $admin = Auth::user();

        $request->validate(['status' => 'required|in:under_review,interview,offer,rejected,accepted',]);
        
        $applications = Application::findOrFail($id);

        $updateData = [
            'status' => $request->status,
            'modified_by' => $admin->id,
            'modified_by_username' => $admin->username,
        ];

        $applications->update($updateData);

        return response()->json(['message' => 'Update Status Successfully', 'data' => $applications]);
    }

    // Get applcaiton by company
    public function getByCompany($company)
    {
        $applications = Application::where('company', $company)->latest()->get();
        return response()->json($applications);
    }

    // Get application by department
    public function getByDepartment($department)
    {
        $applications = Application::where('department', $department)->latest()->get();
        return response()->json($applications);
    }

    // Get application by id
    public function show($id)
    {
        $applications = Application::findOrFail($id);
        return response()->json($applications);
    }

}
