<?php
use App\Http\Controllers\Admin\CustomerCommentController;


Route::group(['prefix' => 'comments'], function () {
  Route::controller(CustomerCommentController::class)->group(function () {
    Route::get('/', ['as' => 'comments', 'uses' => 'index']);
    Route::get('/{id}', ['as' => 'comments.edit', 'uses' => 'edit']);
    Route::post('/{id}', ['as' => 'comments.reply', 'uses' => 'reply']);
    Route::get('/{id}/detail', ['as' => 'comments.detail', 'uses' => 'detail']);
 });
});
