<?php
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'user'], function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/', ['as' => 'user', 'uses' => 'index']);
        Route::get('/add', ['as' => 'user.add', 'uses' => 'add']);
        Route::post('/store', ['as' => 'user.store', 'uses' => 'store']);
        Route::get('/{id}/edit', ['as' => 'user.edit', 'uses' => 'edit']);
        Route::get('/{id}/delete]', ['as' => 'user.delete', 'uses' => 'delete']);
        Route::post('/{id}/update', ['as' => 'user.update', 'uses' => 'update']);
    });
});
