<?php

namespace App\Http\Controllers;

use App\Models\MediaImage;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaImageController extends Controller
{
    /**
     * Upload additional images for a media article
     */
    // public function store(Request $request)
    // {
    //     // $media = Media::findOrFail($mediaId);

    //     $validated = $request->validate([
    //         'path' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
    //     ]);

    //     if($request->hasFile('path')){
    //         $path = $request->file('path')->store('article_img', 'public');
    //         $validated['path'] = $path;
    //     }

    //     $mediaImages = MediaImage::create([
    //         'media_id' => $request->media_id,
    //         'path' => $validated['path'],
    //     ]);

    //     // if ($request->hasFile('images')) {
    //     //     foreach ($request->file('images') as $image) {
    //     //         $path = $image->store('media_images', 'public');
    //     //         $mediaImage = MediaImage::create([
    //     //             'media_id' => $media->id,
    //     //             'path' => $path,
    //     //         ]);
    //     //         $uploadedImages[] = $mediaImage;
    //     //     }
    //     // }

    //     return response()->json([
    //         'message' => 'Images uploaded successfully',
    //         'images' => $mediaImages
    //     ]);
    // }

    public function store(Request $request)
{
    $validated = $request->validate([
        'path' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
    ]);

   if($request->hasFile('path')){
            $path = $request->file('path')->store('article_img', 'public');
            $validated['path'] = $path;
    }

    $mediaImages = MediaImage::create([
        'media_id' => $request->media_id,
        'path' => $path,
    ]);

    return response()->json([
        'message' => 'Images uploaded successfully',
        'images' => $mediaImages
    ]);
}


    /**
     * Delete a specific image
     */
    public function destroy($id)
    {
        $image = MediaImage::findOrFail($id);

        // Optionally delete file from storage
        if (\Storage::disk('public')->exists($image->path)) {
            \Storage::disk('public')->delete($image->path);
        }

        $image->delete();

        return response()->json([
            'message' => 'Image deleted successfully'
        ]);
    }

    /**
     * Get all images for a media article
     */
    public function index($mediaId)
    {
        $media = Media::findOrFail($mediaId);

        $images = $media->images; 

        return response()->json($images);
    }
}
