<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\VilleController;
use App\Http\Controllers\QuartierController;
use App\Http\Controllers\ProprieteController;

Route::post('/login',[AuthController::class, 'login']);
Route::post('/register',[AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);

    Route::get('/villes', [VilleController::class, 'index']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('proprietes', ProprieteController::class);

// Routes personnalisées pour le contrôleur Designation
Route::get('designations', [DesignationController::class, 'index']);
Route::get('designations/{id}', [DesignationController::class, 'show']);
Route::post('designations', [DesignationController::class, 'store']);
Route::put('designations/{id}', [DesignationController::class, 'update']);
Route::delete('designations/{id}', [DesignationController::class, 'destroy']);


// Routes personnalisées pour le contrôleur Ville
Route::post('/villes', [VilleController::class, 'store']);
Route::get('/villes/{id}', [VilleController::class, 'show']);
Route::put('/villes/{id}', [VilleController::class, 'update']);
Route::delete('/villes/{id}', [VilleController::class, 'destroy']);

// Routes personnalisées pour le contrôleur Quartier
Route::get('/quartiers', [QuartierController::class, 'index']);
Route::post('/quartiers', [QuartierController::class, 'store']);
Route::get('/quartiers/{id}', [QuartierController::class, 'show']);
Route::put('/quartiers/{id}', [QuartierController::class, 'update']);
Route::delete('/quartiers/{id}', [QuartierController::class, 'destroy']);