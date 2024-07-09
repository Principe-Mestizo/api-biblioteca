<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutoresController;
use App\Http\Controllers\GenerosController;
use App\Http\Controllers\LibrosController;
use App\Http\Controllers\PrestamosController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);

});



Route::group(['prefix' => 'biblioteca'], function() {

    Route::apiResource('/generos', GenerosController::class);
    Route::apiResource('/autores', AutoresController::class);
    Route::apiResource('/libros', LibrosController::class);

    Route::apiResource('/prestamos', PrestamosController::class);


});