<?php

namespace App\Http\Controllers;

use App\Models\UpcomingEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UpcomingEventController extends Controller
{
    // -------------------------
    // List events
    // -------------------------
    public function index(Request $request)
    {
        $user = $request->user();
        $now = now();

        if ($user && $user->role === 'admin') {
            $events = UpcomingEvent::orderBy('end_date', 'asc')->get();

        // Add a computed "status" field: 'upcoming' or 'expired'
            // $events->transform(function ($event) use ($now) {
            //     $event->status = $event->end_date < $now ? 'upcoming' : 'expired';
            //     return $event;
            // });

            return response()->json($events);
        }

        // // Normal user: only active events
        $events = UpcomingEvent::where('end_date', '>=', $now)
            ->orderBy('start_date', 'asc')
            ->get(); // all columns included

        return response()->json($events);
    }

    // -------------------------
    // Create event
    // -------------------------
    public function store(Request $request)
    {
        $event = UpcomingEvent::create([
            'title'           => $request->title,
            'detail'          => $request->detail,
            'start_date'      => $request->start_date,
            'end_date'        => $request->end_date,
            'location'        => $request->location,
            'num_participate' => $request->num_participate,
            'organizer'       => $request->organizer,
            'contact'         => $request->contact,
            'media_id'        => $request->media_id,
        ]);

        return response()->json([
            'message' => 'Event created successfully',
            'data'    => $event
        ], 201);
    }

    // -------------------------
    // Update event
    // -------------------------
    public function update(Request $request, UpcomingEvent $event)
    {
        $event->update($request->only([
            'title',
            'detail',
            'start_date',
            'end_date',
            'location',
            'num_participate',
            'organizer',
            'contact',
            'media_id'
        ]));

        $event->refresh();

        return response()->json([
            'message' => 'Event updated successfully',
            'data'    => $event
        ]);
    }
}
