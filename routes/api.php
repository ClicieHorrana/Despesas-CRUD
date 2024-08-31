<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;

Route::post("/login", [AuthController::class, 'auth']);
Route::post('/register', [AuthController::class,'register']);
Route::post("/logout", [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('/expenses', ExpenseController::class);
});
