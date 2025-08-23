<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\MediaImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    // -------------------------
    // List active media
    // -------------------------
    public function index()
    {
        $media = Media::latest()->get();
        return response()->json($media);
    }

    // -------------------------
    // List archived media
    // -------------------------
    public function archived()
    {
        $archived = Media::onlyTrashed()->latest()->get();
        return response()->json($archived);
    }

    // -------------------------
    // Get media by ID (include trashed)
    // -------------------------
    public function show($id)
    {
        $media = Media::withTrashed()->with('images')->findOrFail($id);
        return response()->json($media);
    }

    // -------------------------
    // Get media by category
    // -------------------------
    public function getByCategory($category)
    {
        $media = Media::where('category', $category)->latest()->get();
        return response()->json($media);
    }

    // -------------------------
    // Create new media with multiple images
    // -------------------------
    public function store(Request $request)
    {
        $admin = Auth::user();

        $validated = $request->validate([
            'category' => 'required|in:activity,gallery,knowledge,article,upcoming_event',
            'title' => 'required|string|max:255',
            'thumbnail_img' => 'image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'sometimes|in:draft,schedule,published',
            'scheduled_at' => 'nullable|required_if:status,schedule|date_format:Y-m-d H:i',
        ]);

        // Upload thumbnail if exists
        if ($request->hasFile('thumbnail_img')) {
            $path = $request->file('thumbnail_img')->store('thumbnail_imgs', 'public');
            $validated['thumbnail_img'] = $path;
        }

        // Create media
        $media = Media::create([
            'category'              => $validated['category'],
            'title'                 => $validated['title'],
            'thumbnail_img'         => $validated['thumbnail_img'],
            'source'                => $request->source ?? 'facebook',
            'url'                   => $request->url,
            'article_detail'        => $request->article_detail ?? null,
            'status'                => $validated['status'] ?? 'draft',
            'published_at'          => $validated['status'] === 'published' ? Carbon::now() : null,
            'scheduled_at'          => $validated['status'] === 'schedule' ? $validated['scheduled_at'] : null,
            'created_by'            => $admin->id,
            'created_by_username'   => $admin->username,
            'modified_by'           => $admin->id,
            'modified_by_username'  => $admin->username,
        ]);

        return response()->json([
            'message' => 'Media created successfully',
            'data' => $media
        ]);
    }

    // -------------------------
    // Update media and optionally add more images
    // -------------------------
    public function update(Request $request, $id)
    {
        $media = Media::withTrashed()->findOrFail($id);
        $admin = Auth::user();

        $validated = $request->validate([
            'category' => 'sometimes|in:activity,gallery,knowledge,article,upcoming_event',
            'title' => 'sometimes|string|max:255',
            'thumbnail_img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        if ($request->hasFile('thumbnail_img')) {
            $path = $request->file('thumbnail_img')->store('thumbnail_imgs', 'public');
            $validated['thumbnail_img'] = $path;
        }

        $media->update([
            'category' => $validated['category'] ?? $media->category,
            'title' => $validated['title'] ?? $media->title,
            'thumbnail_img' => $validated['thumbnail_img'] ?? $media->thumbnail_img,
            'source' => $request->source ?? $media->source,
            'url' => $request->url ?? $media->url,
            'article_detail' => $request->article_detail ?? $media->article_detail,
            'modified_by' => $admin->id,
            'modified_by_username' => $admin->username,
        ]);

        return response()->json([
            'message' => 'Media updated successfully',
            'data' => $media->load('images')
        ]);
    }

    
    // -------------------------
    // Update media status
    // -------------------------
    public function updateStatus(Request $request, $id)
    {
        $media = Media::withTrashed()->findOrFail($id);
        $admin = Auth::user();

        $request->validate([
            'status' => 'required|in:draft,schedule,published',
            'scheduled_at' => 'nullable|date|required_if:status,schedule',
        ]);

        $updateData = [
            'status' => $request->status,
            'published_at' => $request->status === 'published' ? Carbon::now() : $media->published_at,
            'scheduled_at' => $request->status === 'schedule' ? $request->scheduled_at : null,
            'modified_by' => $admin->id,
            'modified_by_username' => $admin->username,
        ];

        $media->update($updateData);

        return response()->json([
            'message' => 'Media status updated successfully',
            'data' => $media
        ]);
    }

    // -------------------------
    // Soft delete / archive media
    // -------------------------
    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        $media->delete(); // soft delete

        return response()->json([
            'message' => 'Media archived successfully'
        ]);
    }

    // -------------------------
    // Restore archived media
    // -------------------------
    public function restore($id)
    {
        $media = Media::onlyTrashed()->findOrFail($id);
        $media->restore();

        return response()->json([
            'message' => 'Media restored successfully',
            'data' => $media
        ]);
    }

    // -------------------------
    // Permanently delete media
    // -------------------------
    public function forceDelete($id)
    {
        $media = Media::onlyTrashed()->findOrFail($id);
        $media->forceDelete();

        return response()->json([
            'message' => 'Media permanently deleted'
        ]);
    }
}
