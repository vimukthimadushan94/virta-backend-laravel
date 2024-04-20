<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/company/create',[CompanyController::class,'store']);
Route::post('/company/update/{id}',[CompanyController::class,'update']);
Route::post('/company/{id}/delete',[CompanyController::class,'delete']);

Route::post('/station/create',[StationController::class,'store']);
Route::put('/station/update/{id}',[StationController::class,'update']);
Route::delete('/station/{id}/delete',[StationController::class,'delete']);
