<?php
use App\Http\Controllers\Admin\SellerController;

Route::group(['prefix' => 'seller'], function () {
    Route::controller(SellerController::class)->group(function () {
        Route::get('/', ['as' => 'seller', 'uses' => 'index']);
        Route::get('/add', ['as' => 'seller.add', 'uses' => 'add']);
        Route::post('/store', ['as' => 'seller.store', 'uses' => 'store']);
        Route::get('/{id}/edit', ['as' => 'seller.edit', 'uses' => 'edit']);
        Route::get('/{id}/history', ['as' => 'seller.history', 'uses' => 'getHistory']);
        Route::get('/{id}/delete]', ['as' => 'seller.delete', 'uses' => 'delete']);
        Route::post('/{id}/update', ['as' => 'seller.update', 'uses' => 'update']);
        Route::post('/detail', ['as' => 'seller.detail', 'uses' => 'getDetail']);
    });
});
