<?php
use App\Http\Controllers\Admin\LengthClassController;

Route::group(['prefix' => 'length-class'], function () {
  Route::controller(LengthClassController::class)->group(function () {
    Route::get('/', ['as' => 'length-class', 'uses' => 'index']);
    Route::get('/add', ['as' => 'length-class.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'length-class.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'length-class.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'length-class.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'length-class.update', 'uses' => 'update']);
 });
});
