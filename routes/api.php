<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResetPasswordController;
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

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::post('login', [AuthController::class, 'store']);
    Route::post('/register', [AuthController::class, 'create']);

    Route::middleware('auth:api')->group(function(){
        Route::get('logout', [AuthController::class, 'destroy']);
        Route::get('news/{lang_id}', [PostController::class, 'get']);
        Route::post('news/create', [PostController::class, 'create']);
        Route::post('news/update', [PostController::class, 'update']);
        Route::post('news/delete', [PostController::class, 'delete']);

        Route::get('feedback', [FeedbackController::class, 'get']);
        Route::post('feedback/create', [FeedbackController::class, 'store']);
        Route::post('feedback/delete', [FeedbackController::class, 'delete']);
        Route::post('feedback/update', [FeedbackController::class, 'update']);

        Route::get('media', [MediaController::class, 'get']);
        Route::post('media/create', [MediaController::class, 'store']);
        Route::post('media/delete', [MediaController::class, 'delete']);
        Route::post('media/update', [MediaController::class, 'update']);

        Route::get('faq', [FaqController::class, 'get']);
        Route::post('faq/create', [FaqController::class, 'store']);
        Route::post('faq/delete', [FaqController::class, 'delete']);
        Route::post('faq/update', [FaqController::class, 'update']);
    });

    Route::post('/profile/password/request', [ForgotPasswordController::class, 'postEmail'])->name('password.request');
    Route::get('/profile/password/reset/{token}', [ResetPasswordController::class, 'getForm'])->name('password.reset');
    Route::post('/profile/password/reset', [ResetPasswordController::class, 'postReset'])->name('password.update');
});
