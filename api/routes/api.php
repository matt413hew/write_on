<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use Illuminate\Http\Request;
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
    }
);


Route::post('login', [AuthController::class, 'login']);
