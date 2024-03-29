<?php

use App\Http\Controllers\AssociateController;
use App\Http\Controllers\RequestDocumentController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WebsiteController::class, 'index'])->name('website.index');
Route::get('/noticias', [WebsiteController::class, 'news'])->name('website.news');
Route::get('/noticias/{information}', [WebsiteController::class, 'information'])->name('website.information');
Route::get('/historia/{category}', [WebsiteController::class, 'category'])->name('website.category');
Route::get('/historia/documentos/{document}', [WebsiteController::class, 'document'])->name('website.document');
Route::get('/historia/documentos/{document}/download', [WebsiteController::class, 'download']);

Route::group(['prefix' => 'suggestion'], function () {
    Route::post('/', [SuggestionController::class, 'store'])->name('suggestion.store');
    Route::get('/{id}/solved/{token}', [SuggestionController::class, 'solved'])->name('suggestion.solved');
});

Route::group(['prefix' => 'associate'], function () {
    Route::post('/', [AssociateController::class, 'store'])->name('associate.store');
    Route::get('/{id}/solved/{token}', [AssociateController::class, 'solved'])->name('associate.solved');
});

Route::group(['prefix' => 'requestDocument'], function () {
    Route::post('/', [RequestDocumentController::class, 'store'])->name('requestDocument.store');
    Route::get('/{id}/solved/{token}', [RequestDocumentController::class, 'solved'])->name('requestDocument.solved');
});

Route::get('/{page}', [WebsiteController::class, 'show'])
    ->where('page', '^(?!nova).*$')
    ->name('website.page');
