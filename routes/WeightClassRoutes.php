<?php
use App\Http\Controllers\Admin\WeightClassController;

Route::group(['prefix' => 'weight-class'], function () {
  Route::controller(WeightClassController::class)->group(function () {
    Route::get('/', ['as' => 'weight-class', 'uses' => 'index']);
    Route::get('/add', ['as' => 'weight-class.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'weight-class.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'weight-class.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'weight-class.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'weight-class.update', 'uses' => 'update']);
 });
});
