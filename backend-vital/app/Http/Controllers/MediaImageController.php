<?php

namespace App\Http\Controllers;

use App\Models\MediaImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaImageController extends Controller
{
    /**
     * Upload multiple images in one request (max 20).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'media_id'     => 'required|exists:media,id',
            'images'       => 'required|array|max:20', // max 20 images per request
            'images.*'     => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'is_cover'     => 'sometimes|boolean', // optional: set one as cover
        ]);

        $createdImages = [];

        foreach ($request->file('images') as $index => $file) {
            $path = $file->store('media_images', 'public');

            // handle cover logic (if first image + is_cover = true OR explicitly set)
            $isCover = false;
            if ($request->boolean('is_cover') && $index === 0) {
                MediaImage::where('media_id', $validated['media_id'])
                    ->update(['is_cover' => false]);
                $isCover = true;
            }

            $image = MediaImage::create([
                'media_id' => $validated['media_id'],
                'path'     => $path,
                'is_cover' => $isCover,
            ]);

            $createdImages[] = [
                'id'       => $image->id,
                'url'      => Storage::url($image->path),
                'is_cover' => $image->is_cover,
            ];
        }

        return response()->json([
            'success' => true,
            'images'  => $createdImages,
        ]);
    }

    /**
     * Replace detail/cover image (single file update).
     */
    public function update(Request $request, $id)
    {
        $image = MediaImage::findOrFail($id);

        $validated = $request->validate([
            'image'    => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'is_cover' => 'sometimes|boolean',
        ]);

        // delete old file
        Storage::disk('public')->delete($image->path);

        // store new one
        $path = $request->file('image')->store('media_images', 'public');

        if ($request->boolean('is_cover')) {
            MediaImage::where('media_id', $image->media_id)->update(['is_cover' => false]);
        }

        $image->update([
            'path'     => $path,
            'is_cover' => $request->boolean('is_cover', $image->is_cover),
        ]);

        return response()->json([
            'id'       => $image->id,
            'url'      => Storage::url($image->path),
            'is_cover' => $image->is_cover,
        ]);
    }

    /**
     * Set cover explicitly.
     */
    public function setCover($id)
    {
        $image = MediaImage::findOrFail($id);

        MediaImage::where('media_id', $image->media_id)->update(['is_cover' => false]);

        $image->update(['is_cover' => true]);

        return response()->json([
            'success'     => true,
            'cover_image' => Storage::url($image->path),
        ]);
    }

    /**
     * Soft delete.
     */
    public function destroy($id)
    {
        $image = MediaImage::findOrFail($id);
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image soft deleted']);
    }

    /**
     * Restore deleted image.
     */
    public function restore($id)
    {
        $image = MediaImage::withTrashed()->findOrFail($id);
        $image->restore();

        return response()->json(['success' => true, 'message' => 'Image restored']);
    }

    /**
     * Permanently delete.
     */
    public function forceDelete($id)
    {
        $image = MediaImage::withTrashed()->findOrFail($id);

        Storage::disk('public')->delete($image->path);

        $image->forceDelete();

        return response()->json(['success' => true, 'message' => 'Image permanently deleted']);
    }
}
