<?php

namespace App\Http\Controllers;

use App\Models\Contact_Message;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $message = Contact_Message::all();
        return response()->json([
            'status' => ' success',
            'data' => $message
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $message = new Contact_Message;
        $message->message_firstname = $request->input('message_firstname');
        $message->message_lastname = $request->input('message_lastname');
        $message->message_email = $request->input('message_email');
        $message->message_phNum = $request->input('message_phNum');
        $message->message_detail = $request->input('message_detail');
        $message->save();
        return $message;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $message = Contact_Message::find($id);
        if (!$message) {
            return response()->json([
                'status' => 'error',
                'message' => 'Message not found'
            ], 404);
        }
        else{
            return response()->json([
                'status' => 'success',
                'data' => $message
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $message = Contact_Message::find($id);
        $message->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Message deleted successfully'
        ], 200);
    }
}
