<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MediaLibraryController;
use App\Http\Controllers\Api\BlogCategoryController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\UserRoleController;
use App\Http\Controllers\Api\UserCapabilitiesController;
use App\Http\Controllers\Api\UserManagerController;
use App\Http\Controllers\Api\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Project routes
    Route::resource('/project', \App\Http\Controllers\Api\ProjectController::class);

    //Media library routes
    Route::post('/media-add', [MediaLibraryController::class, 'addMedia']);
    Route::get('/media-get-all', [MediaLibraryController::class, 'getAllMedia']);
    Route::get('/media-single/{id}', [MediaLibraryController::class, 'getSingleMedia']);
    Route::delete('/media-delete/{id}', [MediaLibraryController::class, 'DeleteSingleMedia']);

    //Blog
    Route::post('/blog-add', [BlogController::class, 'addBlog']);
    Route::get('/blog-all', [BlogController::class, 'blogGetAll']);
    Route::get('/blog-single/{id}', [BlogController::class, 'getSingleBlog']);
    Route::put('/blog-single/{id}', [BlogController::class, 'updateSingleBlog']);
    Route::delete('/blog-single/{id}', [BlogController::class, 'deleteSingleBlog']);

    Route::get('/blog-comments', [BlogController::class, 'blogComments']);

    Route::post('/blog-cat-add', [BlogCategoryController::class, 'addBlogCategory']);
    Route::get('/blog-cat-all', [BlogCategoryController::class, 'getAllCategories']);
    Route::delete('/blog-cat-delete/{blogCat}', [BlogCategoryController::class, 'deleteBlogCat']);
    Route::get('/blog-cat-single/{blogCat}', [BlogCategoryController::class, 'getSingleCat']);
    Route::put('/blog-cat-update/{blogCat}', [BlogCategoryController::class, 'updateCategory']);


    //User
    Route::resource('/user-role', UserRoleController::class);
    Route::resource('/user-capability', UserCapabilitiesController::class);
    Route::resource('/user-manager', UserManagerController::class);
    Route::post('/assign-role-onuser', [UserManagerController::class, 'AssignRoleOnUser']);
    Route::post('/roles-from-user', [UserManagerController::class, 'RolesFromUser']);
    Route::post('/assign-caps-onrole', [UserManagerController::class, 'AssignCapsInRole']);
    Route::post('/permissions-from-role', [UserManagerController::class, 'PermissionsFromRole']);
    Route::get('/current-user', [UserManagerController::class, 'CurrentUserData']);
    Route::get('/total-user-count', [UserManagerController::class, 'TotalUserCount']);
    
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/auth-check', [UserManagerController::class, 'authChecker']);


require __DIR__.'/client.php';