<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Media;
use App\Models\UpcomingEvent;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Auto update event timeline
        $schedule->call(function () {
            UpcomingEvent::where('timeline', 'upcoming')
                ->where('end_date', '<', Carbon::now())
                ->update(['timeline' => 'expired']);
        })->everyMinute();

        // Auto-publish media drafts
        // $schedule->call(function () {
        //     Media::where('status', 'draft')
        //         ->whereNotNull('publish_at')
        //         ->where('publish_at', '<=', now())
        //         ->update(['status' => 'published']);
        // })->everyTenMinutes();

        // Auto-publish scheduled media
         $schedule->command('media:publish-scheduled')
                  ->everyMinute()
                  ->appendOutputTo(storage_path('logs/scheduler.log'));

        // Auto-delete media after 30 days of soft delete
        $schedule->call(function () {
            Media::onlyTrashed()
                ->where('deleted_at', '<', now()->subDays(30))
                ->forceDelete();
        })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
