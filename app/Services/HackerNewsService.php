<?php

namespace App\Services;

use App\Jobs\SpoolAuthorJob;
use App\Jobs\SpoolCommentJob;
use App\Jobs\SpoolStoryJob;
use Illuminate\Support\Facades\Http;
use App\Models\Story;
use App\Models\Author;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;





class HackerNewsService
{
    public function spoolStories()
    {
        $response = Http::get('https://hacker-news.firebaseio.com/v0/topstories.json');
        $stories = $response->json();
        // Limit the number of stories to 100
        $stories = array_slice($stories, 0, 20);
    
        foreach ($stories as $storyId) {
            // dispatch each story to a queue
            SpoolStoryJob::dispatch($storyId);
        }
        return $stories;
    }


    public function spoolStory($storyId)
    {
        // Logic for spooling stories for a given story ID
        $storyResponse = Http::get("https://hacker-news.firebaseio.com/v0/item/{$storyId}.json");
        $storyData = $storyResponse->json();
        // Validate the story before processing it
        $validator = Validator::make($storyData, [
            'title' => 'required|unique:stories',
        ]);

        if ($validator->passes()) {
            // Check if the story has kids (comments)
            if (isset($storyData['kids'])) {
                foreach ($storyData['kids'] as $commentId) {
                    //dispatch spoolcomment job
                    SpoolCommentJob::dispatch($commentId);
                }
            };
            Story::updateOrCreate(['id' => $storyId], [
                'story_id' => $storyData['id'],
                'title' => $storyData['title'],
                'author' => $storyData['by'],
                'score' => $storyData['score'],
                'url' => $storyData['url'],
                'category' => $storyData['category'] ?? null,
            ]);

            //dispatch SpoolAuthorJob for the story author
            $authorId = $storyData['by'];
            SpoolAuthorJob::dispatch($authorId);
        }

    }

    public function spoolAuthor($authorId)
    {
        // Logic for spooling authors for a given author ID
        $authorResponse = Http::get("https://hacker-news.firebaseio.com/v0/user/{$authorId}.json");
        $authorData = $authorResponse->json();
        $authorValidationData = [
            'name' => $authorData['id'],
            'about' => $authorData['about'] ?? null,
        ];

        $validator = Validator::make($authorValidationData, [
            'name' => 'required|unique:authors',
        ]);

        if ($validator->passes()) {
            // Store author data in the database
            Author::updateOrCreate(['id' => $authorId], [
                'name' => $authorData['id'],
                'about' => $authorData['about'] ?? null,
            ]);
        }
    }

    public function spoolComments($commentId)
    {
        // Logic for spooling comments for a given comment ID
        $commentResponse = Http::get("https://hacker-news.firebaseio.com/v0/item/{$commentId}.json");
        $commentData = $commentResponse->json();
        $authorId = $commentData['by'];
        $validator = Validator::make($commentData, [
            'text' => 'required|unique:comments',
        ]);

        if ($validator->passes()) {
                // Store comment data in the database
                Comment::updateOrCreate(['id' => $commentId], [
                    'story_id' => $commentData['parent'],
                    'comment_id' => $commentData['id'],
                    'text' => $commentData['text'],
                    'author' => $authorId,
                ]);
                //dispatch SpoolAuthorJob for the comment author
                SpoolAuthorJob::dispatch($authorId);
                // Recursively spool comments for this comment (if it has kids)
                if (isset($commentData['kids'])) {
                    foreach ($commentData['kids'] as $childcommentId) {
                        //dispatch spoolcomment job
                        SpoolCommentJob::dispatch($childcommentId);
                    }
                }
        }
    }

}
