<?php

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
Route::post('login', [App\Http\Controllers\UserController::class, 'login']);
Route::get('unit', [App\Http\Controllers\UnitController::class, 'index']);
Route::post('registrar', [App\Http\Controllers\TicketController::class,'registrar']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    //return $request->user();
    
    Route::post('me', [App\Http\Controllers\UserController::class, 'me']);
    Route::post('logout', [App\Http\Controllers\UserController::class, 'logout']);
    Route::apiResource('user', App\Http\Controllers\UserController::class);
    Route::put('/updatePassword/{user}',[\App\Http\Controllers\UserController::class,'updatePassword']);
    Route::post('/cambioEstado/{id}',[\App\Http\Controllers\UserController::class,'cambioEstado']);
   
    Route::post('/atender',[\App\Http\Controllers\UserController::class,'atender']);
    Route::post('/datosatender',[\App\Http\Controllers\UserController::class,'datosatender']);
    Route::post('/ultificha',[\App\Http\Controllers\UserController::class,'ultificha']);
    
    
});
