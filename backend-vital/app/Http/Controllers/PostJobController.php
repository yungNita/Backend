<?php

namespace App\Http\Controllers;

use App\Models\Post_Job;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PostJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $job = Post_Job::all();
        return response()->json([
            'status' => 'success',
            'data' => $job
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $job = new Post_Job;
        $job->position = $request->input('position');
        $job->salary = $request->input('salary');
        $job->location = $request->input('location');
        $job->deadline = $request->input('deadline');
        $job->working_shift = $request->input('working_shift');
        $job->job_detail = $request->input('job_detail');
        $job->employment_type = $request->input('employment_type');
        $job->department = $request->input('department');
        $job->company = $request->input('company');
        $job->save();
        return response()->json([
            'status' => 'success',
            'data' => $job
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $job_id)
    {
        //
        $job = Post_Job::find($job_id);
        if (!$job) {
            return response()->json([
                'status' => 'error',
                'message' => 'Job not found'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $job
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $job_id)
    {
        //
        $job = Post_Job::find($job_id);
        if (!$job) {
            return response()->json([
                'status' => 'error',
                'message' => 'Job not found'
            ], 404);
        }
        else{
            $job->update($request->only([
                'position',
                'salary',
                'location',
                'deadline',
                'working_shift',
                'job_detail',
                'employment_type',
                'department',
                'company',
                'published_by',
                'published_at',
                'scheduled_at',
                'job_updated_by',
                'status',
                'scheduled_at',
                'closed_at'
            ]));
            return response()->json([
                'status' => 'success',
                'message' => 'Job updated successfully',
                'data' => $job
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $job_id)
    {
        //
        $job = Post_Job::find($job_id);
        if (!$job) {
            return response()->json([
                'status' => 'error',
                'message' => 'Job not found'
            ], 404);
        }
        else {
            $job->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Job deleted successfully, Here are all deleted jobs:',
                'data' => $job = Post_Job::onlyTrashed()->get()
            ], 200);
        }
    }

    public function restore(string $job_id){
        $job = Post_Job::withTrashed()->find($job_id);
        if (!$job) {
            return response()->json([
                'status' => 'error',
                'message' => 'Job not found'
            ], 404);
        }
        else {
            $job->restore();
            return response()->json([
                'status' => 'success',
                'message' => 'Job restored successfully, Here are all jobs:',
                'data' => Post_Job::all()
            ], 200);
        }
    }

    public function publish(string $job_id){
        $job = Post_Job::find($job_id);
        if (!$job) {
            return response()->json([
                'status' => 'error',
                'message' => 'Job not found'
            ], 404);
        }
        else {
            $job->status = 'published';
            $job->published_at = now();
            $job->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Job published successfully',
                'data' => $job
            ], 200);
        }
    }

    public function schedule(string $job_id, Request $request){
        $job = Post_Job::find($job_id);

        if (!$job) {
            return response()->json([
                'status' => 'error',
                'message' => 'Job not found'
            ], 404);
        }

        // Validate scheduled_at
        $request->validate([
            'scheduled_at' => 'required|date|after:now',
        ]);

        // Set scheduled_at in UTC and status to 'scheduled'
        $job->status = 'scheduled';
        $job->scheduled_at = Carbon::parse($request->input('scheduled_at'), 'UTC');
        $job->published_at = null; // leave null until scheduler runs
        $job->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Job scheduled successfully',
            'data' => $job
        ], 200);
    }

    public function close(string $job_id){
        $job = Post_Job::find($job_id);
        if (!$job) {
            return response()->json([
                'status' => 'error',
                'message' => 'Job not found'
            ], 404);
        }
        else {
            $job->status = 'closed';
            $job->closed_at = now();
            $job->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Job closed successfully',
                'data' => $job
            ], 200);
        }
    }
}
