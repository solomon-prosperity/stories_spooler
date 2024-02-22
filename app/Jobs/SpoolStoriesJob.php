<?php

namespace App\Jobs;

use App\Services\HackerNewsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class SpoolStoriesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $hackerNewsService;
    public function __construct(HackerNewsService $hackerNewsService)
    {
        $this->hackerNewsService = $hackerNewsService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->hackerNewsService->spoolStories();
    }
}
