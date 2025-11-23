<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WebhookLokalController;
use App\Http\Controllers\WhatsAppWebhookController;

//Route::any('/webhook/fonnte', [WebhookController::class, 'handle']);
Route::post('/webhook/lokal', [WebhookLokalController::class, 'handle']);
Route::get('/getspp/{nis}',[WebhookLokalController::class, 'getSPP']);
//Route::post('/webhook/test', [WhatsAppWebhookController::class, 'handleWebhook']);