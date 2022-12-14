<?php
use App\Http\Controllers\Admin\AutoPriceChangeDetailController;
use App\Http\Controllers\Admin\AutoPriceController;
use App\Http\Controllers\Admin\HistoryController;

Route::group(['prefix' => 'history'], function () {
    Route::controller(HistoryController::class)->group(function () {
        Route::get('/auto_sell', ['as' => 'auto_sell_history', 'uses' => 'index']);
        Route::get('/transaction/{id}', ['as' => 'transaction_history', 'uses' => 'transaction']);
    });
    Route::controller(AutoPriceController::class)->group(function () {
        Route::get('/auto_price', ['as' => 'auto_price_history', 'uses' => 'index']);
    });
    Route::controller(AutoPriceChangeDetailController::class)->group(function () {
        Route::get('/auto_price/{id}', ['as' => 'auto_price_detail_history', 'uses' => 'index']);
    });
});
