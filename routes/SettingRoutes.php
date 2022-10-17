<?php
use App\Http\Controllers\Admin\SettingController;

Route::group(['prefix' => 'setting'], function () {
    Route::controller(SettingController::class)->group(function () {
        Route::get('/', ['as' => 'setting', 'uses' => 'index']);
        Route::get('/add', ['as' => 'setting.add', 'uses' => 'add']);
        Route::post('/store', ['as' => 'setting.store', 'uses' => 'store']);
        Route::get('/{id}/edit', ['as' => 'setting.edit', 'uses' => 'edit']);
        Route::get('/{id}/delete]', ['as' => 'setting.delete', 'uses' => 'delete']);
        Route::post('/{id}/update', ['as' => 'setting.update', 'uses' => 'update']);
    });
});
