<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Web\ProjectController;
use App\Http\Controllers\Api\Client\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/projects', [ProjectController::class, 'showAllProjects'])->name('projects');
    
    Route::get('/projects/{project}/edit', [ProjectController::class, 'showEditForm']);
    Route::put('/projects/{project}/edit', [ProjectController::class, 'updateProject']);
});

require __DIR__.'/auth.php';
require __DIR__.'/lwire.php';
