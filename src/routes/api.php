<?php

use App\Http\Controllers\InvoiceAPIController;
use Illuminate\Support\Facades\Route;

Route::get('/get_invoices', [InvoiceAPIController::class, 'get_invoices']);
Route::get('/create_invoice', [InvoiceAPIController::class, 'create_invoice']);
Route::get('/get_invoice_details/{id}', [InvoiceAPIController::class, 'get_invoice_details']);
Route::post('/update_invoice', [InvoiceAPIController::class, 'update_invoice']);