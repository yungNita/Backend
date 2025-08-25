<?php

namespace App\Jobs;

use App\Models\MediaImage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ProcessMediaImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $image;

    public function __construct(MediaImage $image)
    {
        $this->image = $image;
    }

    public function handle()
    {
        $path = $this->image->path;
        $fullPath = storage_path("app/public/{$path}");

        $manager = new ImageManager(['driver' => 'imagick']); 
        $img = $manager->make($fullPath)->resize(1920, null, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });

        $img->save($fullPath, 80); // compress quality to 80%

        $thumbPath = str_replace("media_images/", "media_images/thumbs/", $path);
        Storage::disk('public')->makeDirectory("media_images/thumbs");
        $img->resize(400, null, fn ($c) => $c->aspectRatio())->save(storage_path("app/public/{$thumbPath}"));

        $this->image->update([
            'thumbnail_path' => $thumbPath
        ]);
    }
}
