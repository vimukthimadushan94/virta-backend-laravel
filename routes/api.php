<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/company/create',[CompanyController::class,'store']);
Route::post('/company/update/{id}',[CompanyController::class,'update']);
