<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductsController;
Route::get('/register',[AuthController::class, 'index']);
Route::post('/registerr',[AuthController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

// ================= ADMIN =================
Route::middleware(['auth:sanctum', 'role:admin'])->group(function(){
    Route::get('/test', function(){
        return response()->json([
            'success' => 'testing success',
        ]);
    });
//     Route::get('/admin', function(){
//     return "welcome to admin";
// });
});

Route::middleware(['auth:sanctum', 'role:user'])->group(function(){
    Route::get('/user', function(){
        return "welcome to user";
    });
});

Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/products', ProductsController::class);
