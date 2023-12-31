<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum', 'throttle:60,1')->group(
    function () {
        //auth
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('roles', [AuthController::class, 'getRoles']);
        Route::post('new/user', [AuthController::class, 'addUser']);
        //user
        Route::get('users/all', [UsersController::class, 'getUsers']);
        Route::post('activate/user', [UsersController::class, 'activateUser']);
        //company
        Route::post('companies', [CompanyController::class, 'getCompanies']);
        Route::post('all/companies', [CompanyController::class, 'getAllCompanies']);
        Route::post('activate/company', [CompanyController::class, 'activateCompany']);
        Route::post('create/company', [CompanyController::class, 'addCompany']);
        //article
        Route::post('create/article', [ArticleController::class, 'createArticle']);
        Route::post('publish/article', [ArticleController::class, 'publishArticle']);
        Route::get('get/for-edit', [ArticleController::class, 'getForEdit']);
        Route::get('get/published', [ArticleController::class, 'getPublished']);
        Route::get('get/articles', [ArticleController::class, 'getAll']);
        Route::post('get/article', [ArticleController::class, 'getArticle']);
        Route::post('update/article', [ArticleController::class, 'updateArticle']);
        //image
        Route::post('create/image', [ImageController::class, 'chunk_upload']);
    }
);
Route::get('/preview_image/{file_name}', [ImageController::class, 'preview_image']);
Route::post('login', [AuthController::class, 'login']);
