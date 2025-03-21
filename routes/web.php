<?php

use App\Http\Controllers\PdfController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/orders/{order}/order-pdf', [PdfController::class, 'OrderPdf'])->name('order.pdf');
