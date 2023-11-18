<?php

use Illuminate\Support\Facades\Route;
use Oriworks\NewsletterSystem\Http\Controllers\NewsletterController;

Route::group(['prefix' => 'newsletter'], function () {
    Route::post('/signup', [NewsletterController::class, 'signup'])->name('newsletter.signup');
    Route::get('/verify/{token}', [NewsletterController::class, 'verify'])->name('newsletter.verify');
    Route::get('/cancel/{token}', [NewsletterController::class, 'cancel'])->name('newsletter.cancel');
    Route::get('/{newsletter}', [NewsletterController::class, 'newsletter'])->name('newsletter.view');
});
