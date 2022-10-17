<?php
use App\Http\Controllers\Admin\SecurityQuestionController;

Route::group(['prefix' => 'question'], function () {
    Route::controller(SecurityQuestionController::class)->group(function () {
        Route::get('/', ['as' => 'question', 'uses' => 'index']);
        Route::get('/add', ['as' => 'question.add', 'uses' => 'add']);
        Route::post('/store', ['as' => 'question.store', 'uses' => 'store']);
        Route::get('/{id}', ['as' => 'question.edit', 'uses' => 'edit']);
        Route::post('/{id}', ['as' => 'question.update', 'uses' => 'update']);
        Route::get('/{id}/delete', ['as' => 'question.delete', 'uses' => 'delete']);
    });
});
