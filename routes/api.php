<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/invoices', [InvoiceController::class, 'index']);
Route::get('/invoices/avg_days', [InvoiceController::class, 'avgDayProcessThisMonth']);
Route::get('/invoices/avgdays-m', [InvoiceController::class, 'avgDayProcessByMonth']);
Route::get('/invoices/avgdays-y', [InvoiceController::class, 'avgDayProcessThisYear']);
Route::get('/invoices/receivetmcount', [InvoiceController::class, 'receiveThisMonthCount']);
Route::get('/invoices/countbycreator', [InvoiceController::class, 'invoiceByCreatorMonthly']);
Route::get('/invoices/thisyearmonths', [InvoiceController::class, 'thisYearMonths']);
Route::get('/invoices/thismprocessed', [InvoiceController::class, 'thisMonthProcesed']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




