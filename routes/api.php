<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\RegisterController;
use App\Http\Controllers\API\V1\SurveyController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Version 1 routes
Route::prefix('v1')->group(function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [RegisterController::class, 'login']);
    
    //
    Route::group(['prefix' => 'survey','middleware' => 'auth:sanctum'], function () {
        // Route for submitting survey
        Route::post('store', [SurveyController::class, 'store']);
        Route::post('/', [SurveyController::class, 'create']);
    });

});

