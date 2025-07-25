<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuotationController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/quotations', [QuotationController::class, 'index'])->name('quotation.index');
    Route::post('/quotations', [QuotationController::class, 'store'])->name('quotation');
    Route::get('/quotations/{quotation}', [QuotationController::class, 'show'])->name('quotation.show');
});
