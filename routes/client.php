<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Client\ProjectController;
use App\Http\Controllers\Api\Client\BlogController;
use App\Http\Controllers\Api\Client\CommentController;



// Project routes
Route::get('/all-projects', [ProjectController::class, 'allProjects']);


// Blog routes
Route::get('/all-blogs', [BlogController::class, 'allBlogs']);
Route::get('/single-blog/{blog:slug}', [BlogController::class, 'singleBlog']);


// Comment routes
Route::post('/comment-post', [CommentController::class, 'postComment']);