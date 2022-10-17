<?php
use App\Http\Controllers\Admin\ReviewController;

Route::group(['prefix' => 'review'], function () {
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/', ['as' => 'review', 'uses' => 'index']);
        Route::get('/add', ['as' => 'review.add', 'uses' => 'add']);
        Route::post('/store', ['as' => 'review.store', 'uses' => 'store']);
        Route::get('/{id}/edit', ['as' => 'review.edit', 'uses' => 'edit']);
        Route::get('/{id}/view', ['as' => 'review.view', 'uses' => 'view']);
        Route::get('/{id}/delete]', ['as' => 'review.delete', 'uses' => 'delete']);
        Route::post('/{id}/update', ['as' => 'review.update', 'uses' => 'update']);
    });
});
