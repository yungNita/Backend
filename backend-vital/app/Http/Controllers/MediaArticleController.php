<?php

namespace App\Http\Controllers;

use App\Models\MediaArticle;
use Illuminate\Http\Request;

class MediaArticleController extends Controller
{
    public function index()
    {
        $articles = MediaArticle::with('media')->latest()->get();
        return response()->json($articles);
    }

    public function store(Request $request)
    {
        $article = MediaArticle::create($request->only(['media_id', 'detail']));

        return response()->json([
            'message' => 'Article created successfully',
            'data' => $article
        ]);
    }

    public function show(MediaArticle $mediaArticle)
    {
        return response()->json($mediaArticle->load('media', 'image'));
    }

    public function update(Request $request, MediaArticle $mediaArticle)
    {
        $mediaArticle->update($request->only(['detail']));

        return response()->json([
            'message' => 'Article updated successfully',
            'data' => $mediaArticle
        ]);
    }

    public function destroy(MediaArticle $mediaArticle)
    {
        $mediaArticle->delete();

        return response()->json([
            'message' => 'Article deleted successfully'
        ]);
    }
}
