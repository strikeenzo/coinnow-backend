<?php
use App\Http\Controllers\Admin\DigitalShowImageController;

Route::group(['prefix' => 'digital'], function () {
    Route::controller(DigitalShowImageController::class)->group(function () {
        Route::get('/', ['as' => 'digital', 'uses' => 'index']);
    });
});
