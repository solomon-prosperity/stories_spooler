<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HackerNewsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/stories', [HackerNewsController::class, 'listStories']);
Route::get('/authors', [HackerNewsController::class, 'listAuthors']);
Route::get('/comments', [HackerNewsController::class, 'listComments']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
