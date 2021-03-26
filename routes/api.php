<?php

use App\Http\Controllers\API\ConfirmationController;
use App\Http\Controllers\API\GreetCardController;
use App\Http\Controllers\API\TemplateImageController;
use App\Http\Controllers\API\WeddingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('wedding')->group(function() {
    Route::get('/', [WeddingController::class, 'index']);
    Route::post('/', [WeddingController::class, 'create']);
    Route::patch('{wedding:id}', [WeddingController::class, 'update']);
    Route::get('/{wedding:slug}', [WeddingController::class, 'show']);
    Route::post('{wedding:id}/active', [WeddingController::class, 'active']);
    Route::delete('{wedding:id}/destroy', [WeddingController::class, 'destroy']);
});

Route::prefix('greeting_card')->group(function() {
    Route::get('{wedding:id}', [GreetCardController::class, 'index']);
    Route::post('{wedding:id}', [GreetCardController::class, 'create']);
    Route::delete('{greeting_card:id}/destroy', [GreetCardController::class, 'destroy']);
});

Route::prefix('confirmation')->group(function() {
    Route::get('{wedding:id}', [ConfirmationController::class, 'index']);
    Route::post('{wedding:id}', [ConfirmationController::class, 'create']);
    Route::delete('{confirmation:id}/destroy', [ConfirmationController::class, 'destroy']);
});

Route::prefix('template_image')->group(function() {
    Route::get('{wedding:id}', [TemplateImageController::class, 'get']);
    Route::post('{wedding:id}/create', [TemplateImageController::class, 'create']);
    Route::delete('{template_image:id}/destroy', [TemplateImageController::class, 'destroy']);
});