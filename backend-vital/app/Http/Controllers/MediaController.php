<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Media;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    // List all the media categories
    public function index($category)
    {
        $media = Media::where('category', $category)
                -> with(['links', 'article', 'images', 'event'])
                -> get();
        return response()->json($media);
    }

    // List media by id
    public function show($id)
    {
        $media = Medi::with(['links', 'article', 'images', 'event'])->findOrFail($id);
        return response()->json($media);
    }

    // Creat media  
    public function store(Request $request)
    {
        $media = Media::create([
            'category' => $request->category,
            'title' => $request->title,
            'thumbnail_img' => $request->thumbnail_img,
             'source' => $request->source,
             'status' => 'draft',
             'published_at' => $request->published_at,
             'created_by' => auth()->id(),
             'created_by_username' => auth()->user()->username,
        ])

        return response()->json($['message' => 'Create Media successfully', 'media' => $media], 201);
    }

    // update media by id
    public function update(Request $request, $id)
    {
        $media = Media::findOrFail($id);
        $media->update(array_merge($request->all(), [
            'modified_by' => auth()->id(),
            'modified_by_username' => auth()->user()->username,
        ]))

        return response()->json(['message' => 'Updated successfully', 'user' => $user]);
    }

    // Update Status: draff, schedule, published, and archived
    public function updateStatus(Request $request, Media $media)
    {
        $status = $request->status  
    }

    //Soft delete 
    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        $media->delete();

        return response()->json(['message' => 'Delee Successfully']);
    }

}
