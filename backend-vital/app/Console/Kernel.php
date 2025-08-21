<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Post_Job;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // This runs every minute
        $schedule->call(function () {
            // Find all jobs that are scheduled and past their scheduled time
            $jobs = Post_Job::where('status', 'scheduled')
                ->where('scheduled_at', '<=', now()) // now() is UTC
                ->get();

            foreach ($jobs as $job) {
                $job->update([
                    'status' => 'published',
                    'published_at' => now(),
                ]);
            }
        })->everyMinute()->timezone('UTC');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
