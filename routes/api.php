<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\VilleController;
use App\Http\Controllers\QuartierController;
use App\Http\Controllers\ProprieteController;
use App\Http\Controllers\CautionTypeController;
use App\Http\Controllers\HomeController;

Route::post('/login',[AuthController::class, 'login']);
Route::post('/register',[AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
});

Route::put('/user/update/{id}',[HomeController::class, 'updateProfile']);//Update profile
Route::post('/modify-password',[HomeController::class, 'modifyPassword']);//Modify password
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Routes personnalisées pour le contrôleur 
Route::get('/caution_types', [CautionTypeController::class, 'index']);
// Route::apiResource('proprietes', ProprieteController::class);

// Routes personnalisées pour le contrôleur Designation
Route::get('designations', [DesignationController::class, 'index']);
Route::get('designations/{id}', [DesignationController::class, 'show']);
Route::post('designations', [DesignationController::class, 'store']);
Route::put('designations/{id}', [DesignationController::class, 'update']);
Route::delete('designations/{id}', [DesignationController::class, 'destroy']);


// Routes personnalisées pour le contrôleur Ville
Route::get('/villes', [VilleController::class, 'index']);
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

//Produts
Route::get('/chambres', [ProprieteController::class, 'indexAll']);// Show all proprietes
Route::get('/chambres/{id}', [ProprieteController::class, 'showOne']);//Show single propriete
Route::get('/villes/{ville_id}/chambres', [ProprieteController::class, 'ProprietesByVille']);// Show all proprietes in ville
Route::get('/search/chambres', [ProprieteController::class, 'searchProp']);// Show all proprietes per user

Route::get('/stats/proprietes', [ProprieteController::class, 'getStats']);// Search proprietes for proprio
Route::get('/types/proprietes', [ProprieteController::class, 'getProprietesByType']);// Search proprietes for proprio
Route::get('/search/proprietes', [ProprieteController::class, 'searchAdminProp']);// Search proprietes for proprio
Route::get('/villes/{ville_id}/proprietes', [ProprieteController::class, 'getProprietesByVille']);// Show all proprietes in ville
Route::get('/proprietes', [ProprieteController::class, 'index']);// Show all proprietes per user
Route::get('/proprietes/{id}', [ProprieteController::class, 'show']);//Show single propriete
Route::post('/proprietes', [ProprieteController::class, 'store']);//Create proprietes
Route::put('/proprietes/{id}',[ProprieteController::class, 'update'] );//Update propriete
Route::delete('/proprietes/{id}', [ProprieteController::class, 'deletepropriete']);//Delete propriete
Route::post('/proprietes/pictures/add/{id}',[ProprieteController::class, 'addPictures'] );//add picture to propriete
Route::delete('/proprietes/pictures/delete/{id}', [ProprieteController::class, 'deleteproprietepicture']);//Delete propriete pictures
