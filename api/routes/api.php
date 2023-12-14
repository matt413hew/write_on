<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ImageController;
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
        //company
        Route::post('companies', [CompanyController::class, 'getCompanies']);
        //article
        Route::post('create/article', [ArticleController::class, 'createArticle']);
        //image
        Route::post('create/image', [ImageController::class, 'chunk_upload']);
    }
);


Route::post('login', [AuthController::class, 'login']);
