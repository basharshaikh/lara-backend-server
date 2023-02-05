<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Client\BlogController;
use App\Http\Controllers\Api\Client\CommentController;
use App\Http\Controllers\Api\Client\ContactController;
use App\Http\Controllers\Api\Client\ProjectController;



// Project routes
Route::get('/all-projects', [ProjectController::class, 'allProjects']);
Route::get('/all-project-by-one', [ProjectController::class, 'allProjectsByOne']);
Route::get('/single-project/{project}', [ProjectController::class, 'getSingleProject']);


// Blog routes
Route::get('/all-blogs', [BlogController::class, 'allBlogs']);
Route::get('/single-blog/{blog:slug}', [BlogController::class, 'singleBlog']);


// Comment routes
Route::post('/comment-post', [CommentController::class, 'postComment']);

// Contact routes
Route::post('/customer-contact', [ContactController::class, 'createContactFromCustomer']);