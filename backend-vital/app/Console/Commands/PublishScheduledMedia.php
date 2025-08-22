<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Media;
use Carbon\Carbon;

class PublishScheduledMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:publish-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all scheduled media whose scheduled_at time has passed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $updated = Media::where('status', 'schedule')
            ->where('scheduled_at', '<=', Carbon::now())
            ->update([
                'status' => 'published',
                'published_at' => Carbon::now(),
            ]);

        if ($updated > 0) {
            $this->info("✅ {$updated} scheduled media item(s) published.");
            \Log::info("PublishedScheduleMedia: {updated} Media published at" . now());
        } else {
            $this->info("ℹ️ No scheduled media ready to publish.");
            \Log::info("PublishedScheduleMedia: no media publish at" . now());
        }

        return 0;
    }
}
