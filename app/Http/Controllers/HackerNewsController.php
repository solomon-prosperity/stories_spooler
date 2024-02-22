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
