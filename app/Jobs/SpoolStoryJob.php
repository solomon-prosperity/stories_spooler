<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\HackerNewsService;


class SpoolStoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $hackerNewsService;
    protected $storyId;
    public function __construct($storyId)
    {
        $this->storyId = $storyId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $storyId = $this->storyId;
        app(HackerNewsService::class)->spoolStory($storyId);

    }
}
