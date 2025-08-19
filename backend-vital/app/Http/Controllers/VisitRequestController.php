<?php

namespace App\Http\Controllers;

use App\Models\Visit_Request;
use Illuminate\Http\Request;

class VisitRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $visit = Visit_Request::all();
        return response()->json([
            'status' => 'success',
            'data' => $visit
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $visit = new Visit_Request;
        $visit->visit_firstname = $request->input('visit_firstname');
        $visit->visit_lastname = $request->input('visit_lastname');
        $visit->visit_email = $request->input ('visit_email');
        $visit->visit_phNum = $request->input('visit_phNum');
        $visit->visit_institute = $request->input('visit_institute');
        $visit->visit_purpose = $request->input('visit_purpose');
        $visit->visit_amount = $request->input('visit_amount');
        $visit->status = 'pending'; // Default status when creating a new visit request
        $visit->save();
        return $visit;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $visit_id)
    {
        //
        $visit = Visit_Request::find($visit_id);
        return $visit;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $visit_id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        $visit = Visit_Request::find($visit_id);
        if (!$visit) {
            return response()->json([
                'status' => 'error',
                'message' => 'Visit request not found'
            ], 404);
        }
        else{
            $visit->update($request->only('status'));
            return response()->json([
                'status' => 'success',
                'message' => 'Visit request updated successfully',
                'data' => $visit
            ], 200);
        }
        return $visit;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $visit_id)
    {
        //
        $visit = Visit_Request::find($visit_id);
        $visit->delete();
        if(!$visit){
            return response()->json([
                'status' => 'error',
                'message' => 'Visit request not found'
            ]);
        }
        else{
            return response()->json([
                'status' => 'success',
                'message' => 'Visit request deleted successfully'
            ], 200);
        }
    }
}
