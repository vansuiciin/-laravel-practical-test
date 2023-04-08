<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'survey','middleware' => 'auth'], function () {
    // Route for submitting survey
    Route::get('/add_questions', [SurveyController::class, 'index'])->name('survey.add');
    Route::get('/list', [SurveyController::class, 'list'])->name('survey.list');
});

Route::group(['prefix' => 'survey','middleware' => 'auth:sanctum'], function () {
    // Route for submitting survey
    Route::post('store', [SurveyController::class, 'store']);
    Route::post('/', [SurveyController::class, 'create']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
