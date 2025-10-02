<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RFIDController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/rfid/scan', [RFIDController::class, 'handleScan']);
Route::get('/rfid/test', [RFIDController::class, 'test']);