<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\Author;
use App\Models\Comment;

class HackerNewsController extends Controller
{
    /**
     * Display a listing of the stories.
     */
    public function listStories(Request $request)
    {
        $pageNumber = $request->query('pageNumber', 1);
        $perPage = $request->query('perPage', 20);
        $records = Story::paginate($perPage, ['*'], 'page', $pageNumber);
        return $records;
    }

    /**
     * Display a listing of the authors.
     */
    public function listAuthors(Request $request)
    {
        $pageNumber = $request->query('pageNumber', 1);
        $perPage = $request->query('perPage', 20);
        $records = Author::paginate($perPage, ['*'], 'page', $pageNumber);
        return $records;
    }

    /**
     * Display a listing of the comments.
     */
    public function listComments(Request $request)
    {
        $pageNumber = $request->query('pageNumber', 1);
        $perPage = $request->query('perPage', 20);
        $records = Comment::paginate($perPage, ['*'], 'page', $pageNumber);
        return $records;
    }

    /**
     * Display a listing of all author comments.
     */
    public function listAuthorComments(Request $request, $author)
    {
        $pageNumber = $request->query('pageNumber', 1);
        $perPage = $request->query('perPage', 20);
        $records = Comment::where('author', $author)->paginate($perPage, ['*'], 'page', $pageNumber);
        return $records;
    }

    /**
     * Display a listing of all comments belonging to a story.
     */
    public function listStoryComments(Request $request, $story_id)
    {
        $pageNumber = $request->query('pageNumber', 1);
        $perPage = $request->query('perPage', 20);
        $records = Comment::where('story_id', $story_id)->paginate($perPage, ['*'], 'page', $pageNumber);
        return $records;
    }

    /**
     * Display a listing of all author stories.
     */
    public function listAuthorStories(Request $request, $author)
    {
        $pageNumber = $request->query('pageNumber', 1);
        $perPage = $request->query('perPage', 20);
        $records = Story::where('author', $author)->paginate($perPage, ['*'], 'page', $pageNumber);
        return $records;
    }

    /**
     * Retrieve a story by the story id.
     */
    public function getStoryByStoryId(string $story_id)
    {
        $story = Story::where('story_id', $story_id)->firstOrFail();
        return $story;
    }

    /**
     * Retrieve a comment by the comment id.
     */
    public function getCommentByCommentId(string $comment_id)
    {
        $comment = Comment::where('comment_id', $comment_id)->firstOrFail();
        return $comment;
    }

    /**
     * Retrieve an author by author name.
     */
    public function getAuthorByName(string $author_name)
    {
        $author = Author::where('name', $author_name)->firstOrFail();
        return $author;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
