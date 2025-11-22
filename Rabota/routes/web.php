<?php

use App\Http\Controllers\Api\IncomeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\StocksController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {

    // Sales
    Route::get('/sales', [SaleController::class, 'index']);

    // Orders
    Route::get('/orders', [OrderController::class, 'index']);

    // Warehouses
    Route::get('/stocks', [StocksController::class, 'index']);

    // Incomes
    Route::get('/incomes', [IncomeController::class, 'index']);

});
