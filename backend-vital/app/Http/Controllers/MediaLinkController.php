<?php

namespace App\Http\Controllers;

use App\Models\MediaLink;
use Illuminate\Http\Request;

class MediaLinkController extends Controller
{
    public function index()
    {
        $links = MediaLink::with('media')->latest()->get();
        return response()->json($links);
    }

    public function store(Request $request)
    {
        $link = MediaLink::create($request->only(['media_id', 'url']));

        return response()->json([
            'message' => 'Link created successfully',
            'data' => $link
        ]);
    }

    public function show(MediaLink $mediaLink)
    {
        return response()->json($mediaLink->load('media'));
    }

    public function update(Request $request, MediaLink $mediaLink)
    {
        $mediaLink->update($request->only(['url']));
        return response()->json([
            'message' => 'Link updated successfully',
            'data' => $mediaLink
        ]);
    }

    public function destroy(MediaLink $mediaLink)
    {
        $mediaLink->delete();
        return response()->json([
            'message' => 'Link deleted successfully'
        ]);
    }
}
