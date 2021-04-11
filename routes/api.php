<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/invoices', [InvoiceController::class, 'index']);
Route::get('/avg_days', [InvoiceController::class, 'avgDayProcessThisMonth']);
Route::get('/avgdays-m', [InvoiceController::class, 'avgDayProcessByMonth']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




