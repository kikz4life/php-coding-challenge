<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/customers', [\App\Http\Controllers\CustomerController::class, 'index']);
Route::get('/customers/{customerId}', [\App\Http\Controllers\CustomerController::class, 'show']);
