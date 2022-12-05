<?php
use App\Http\Controllers\Admin\EveryDayFeeController;

Route::group(['prefix' => 'fee'], function () {
    Route::controller(EveryDayFeeController::class)->group(function () {
        Route::get('/', ['as' => 'fee', 'uses' => 'index']);
    });
});
