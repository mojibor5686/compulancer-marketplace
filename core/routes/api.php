<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Gateway\PaymentController;

Route::any( 'uddoktapay/callback', [ PaymentController::class, 'uddoktapayCallback' ] )->name( 'user.uddoktapay.callback' );
Route::post( 'uddoktapay/webhook', [ PaymentController::class, 'uddoktapayWebhook' ] )->name( 'user.uddoktapay.webhook' );