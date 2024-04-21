<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\EleveController ;

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

//Route::resource('eleves', EleveController::class);

Route::get('eleves', [EleveController::class, 'index']);
Route::post('eleves', [EleveController::class, 'store']);
Route::get('eleves/{id}', [EleveController::class, 'show']);
Route::get('eleves/{id}/edit', [EleveController::class, 'edit']);
Route::put('eleves/{id}/edit', [EleveController::class, 'update']);
Route::delete('eleves/{eleve}/delete', [EleveController::class, 'destroy']);



 