<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use PHPUnit\Metadata\Group;

Route::post('/register',[AuthController::class,'Register']);
Route::post('/login',[AuthController::class,"login"]);



Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout',[AuthController::class,'logout']);



});

    Route::apiResource('roles',RoleController::class);
    Route::apiResource('users',UserController::class);
    Route::apiResource('address',AddressController::class);
    Route::apiResource('categories',CategoryController::class);
    Route::apiResource('brands',BrandController::class);