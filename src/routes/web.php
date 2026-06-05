<?php

use Hexters\FeedbackNow\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Route;

Route::middleware(config('feedback-now.middleware', ['web']))
    ->prefix(config('feedback-now.route_prefix', 'feedback-now'))
    ->group(function () {
        Route::post('/', [FeedbackController::class, 'store'])
            ->middleware('throttle:20,1')
            ->name('feedback-now.store');
    });
