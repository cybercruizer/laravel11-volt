<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;

Route::any('/webhook/fonnte', [WebhookController::class, 'handle']);
