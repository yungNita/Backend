<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project_Proposal;

class ProjectProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     * post all data from project_proposals table
     * Admin can view all project proposals submitted by users
     */
    public function index()
    {
        // Fetch all project proposals from the database ('key word - all')
        $proposals = Project_Proposal::all();
        return response()->json([
            'status' => 'success',
            'data' => $proposals
        ], 200);
    }

    /**
     * Store a newly created resource in storage. (User submits a project proposal)
     */
    public function store(Request $request)
    {
        $proposal = new Project_Proposal;
        $proposal->project_firstname = $request->input('project_firstname');
        $proposal->project_lastname = $request->input('project_lastname');
        $proposal->project_email = $request->input('project_email');
        $proposal->project_phNum = $request->input('project_phNum');
        $proposal->project_projectName = $request->input('project_projectName');
        $proposal->project_detail = $request->input('project_detail');
        $proposal->status = 'pending'; // Default status when creating a new proposal
        // Handle file upload if a file is provided
        if ($request->hasFile('project_file')) {
            $file = $request->file('project_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $proposal->project_file = $filename;
        }  else {
            $proposal->project_file = null; // Set to null if no file is uploaded
        }
        $proposal->save();
        return $proposal;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $project_id)
    {
        //search for a specific project proposal by ID
        $proposal = Project_Proposal::find($project_id);
        if (!$proposal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project proposal not found'
            ], 404);
        }
        else {
            return response() -> json([
                'status' => 'success',
                'data' => $proposal
            ], 200);
        }
    }

    /**
     * Update project proposal status
     */
    public function update(Request $request, string $project_id){
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        $proposal = Project_Proposal::findOrFail($project_id);
        $proposal->update($request->only('status'));
        return $proposal;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $project_id)
    {
        //delete a specific project proposal by ID
        $proposal = Project_Proposal::find($project_id);
        $proposal -> delete();
        if (!$proposal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project proposal not found'
            ], 404);
        }
        else{
            return response() -> json([
                'status' => 'success',
                'message' => 'Project proposal deleted successfully'
            ], 200);
        }
    }
}
