<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(CompanyController::class)->prefix('company')->group(function () {
    Route::get('/create', 'store');
    Route::post('/update/{id}', 'update');
    Route::post('/{id}/delete', 'delete');
});

Route::controller(StationController::class)->prefix('station')->group(function () {
    Route::get('/create', 'store');
    Route::post('/update/{id}', 'update');
    Route::post('/{id}/delete', 'delete');
    Route::get('/get-by-range', 'getStationsWithinRadius');
});
