<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::post('register', [DeviceController::class, 'register']);

Route::post('purchase', [SubscriptionController::class, 'purchase']);

Route::post('CheckSubscription', [SubscriptionController::class, 'CheckSubscription']);
