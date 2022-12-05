<?php
use App\Http\Controllers\Admin\DigitalShowImageController;

Route::group(['prefix' => 'digital'], function () {
    Route::controller(DigitalShowImageController::class)->group(function () {
        Route::get('/', ['as' => 'digital', 'uses' => 'index']);
        Route::get('/create_product/{id}', ['as' => 'digital.create.product', 'uses' => 'createProduct']);
        Route::post('/store_product/{id}', ['as' => 'digital.store.product', 'uses' => 'storeProduct']);
    });
});
