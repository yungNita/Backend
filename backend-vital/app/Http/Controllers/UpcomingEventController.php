<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Media;
use Illuminate\Support\Facades\Auth;

class UpcomingEventController extends Controller
{
    public function index()
    {

    }
    
    public function show()
    {

    }

    public function store()
    {

    }

    public function update(Request $requst, $id)
    {
        $event = Event::findOrFail($id);
        $event->fill($request->only([
            'title', 
            'detail', 
            'start_date', 
            'end_date',
            'location',
            'num_paticipate',
            'contact',
            'organizer',
            'timeline',
        ]))
        $event->update(array_merge($request->all(), [
            'modified_by' => auth()->id(),
            'modified_by_username' => auth()->user()->username,
        ]))

        $event->save();

        return response()->json(['message' => 'Update successfully']);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json(['message' => 'Delete successfully']);
    }
    
}
