<?php

use App\Models\Post_Job;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    // Find all jobs that are scheduled and past their scheduled time
    $jobs = Post_Job::where('status', 'scheduled')
    ->where('scheduled_at', '<=', now()) // now() is UTC
    ->get();

    foreach ($jobs as $job) {
        $job->update([
            'status' => 'published',
            'is_available' => true, // Set is_available to true when job is published
            'published_at' => now(),
        ]);
    }

    $close_job = Post_Job::where('status', 'published')
    ->where('deadline', '<=' ,now()) // now() is UTC
    ->get();

    foreach ($close_job as $job) {
        $job->update([
            'status' => 'closed',
            'is_available' => false, // Set is_available to false when job is closed
            'closed_at' => now(),
        ]);
    }
});
