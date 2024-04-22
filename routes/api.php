<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

Route::post('/register', [AuthController::class, 'register']);
// Si vous voulez protéger des routes avec Sanctum, vous pouvez utiliser le middleware "auth:sanctum"
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware(['auth:sanctum'])->group(function () {
// Route protégée, par exemple pour récupérer des détails de l'utilisateur connecté
Route::get('/user', function (Request $request) {
        return $request->user(); // Retourne l'utilisateur connecté
    });
});
