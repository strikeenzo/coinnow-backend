<?php
use App\Http\Controllers\Admin\GuideController;

Route::group(['prefix' => 'guide'], function () {
  Route::controller(GuideController::class)->group(function () {
    Route::get('/', ['as' => 'guide','uses' => 'index']);
    Route::get('/add', ['as' => 'guide.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'guide.store', 'uses' => 'store']);
    Route::put('/{id}', ['as' => 'guide.updateStatus', 'uses' => 'updateStatus']);
    Route::get('/{id}', ['as' => 'guide.edit', 'uses' => 'edit']);
    Route::post('/{id}', ['as' => 'guide.update', 'uses' => 'update']);
    Route::get('/{id}/delete]', ['as' => 'guide.delete', 'uses' => 'delete']);
  });
});
