<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\HackerNewsService;


class SpoolCommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $commentId;
    public function __construct($commentId)
    {
        //
        $this->commentId = $commentId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $commentId = $this->commentId;
        app(HackerNewsService::class)->spoolComments($commentId);
    }
}
