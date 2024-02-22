<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\HackerNewsService;


class SpoolAuthorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $authorId;
    public function __construct($authorId)
    {
        //
        $this->authorId = $authorId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $authorId = $this->authorId;
        app(HackerNewsService::class)->spoolAuthor($authorId);
    }
}
