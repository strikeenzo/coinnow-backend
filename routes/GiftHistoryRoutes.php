<?php
use App\Http\Controllers\Admin\GiftHistoryController;

Route::group(['prefix' => 'gift'], function () {
    Route::controller(GiftHistoryController::class)->group(function () {
        Route::get('/', ['as' => 'gift', 'uses' => 'index']);
    });
});
