<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Media;
use Illuminate\Support\Facades\Auth;

class MediaImageController extends Controller
{
    public function index()
    {
        return MediaImage::with(['created_by', 'modified_by'])->get();
    }

    public function show($id)
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $data = MediaLink::findOrFail($id);
        $data->delete();

        return response()->json(['message' => 'Delete Successfully']);
    }
}
