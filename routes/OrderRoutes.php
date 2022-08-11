<?php
use App\Http\Controllers\Admin\OrderController;

Route::group(['prefix' => 'order'], function () {
  Route::controller(OrderController::class)->group(function () {
    Route::get('/', ['as' => 'order', 'uses' => 'index']);
    Route::get('/add', ['as' => 'order.add', 'uses' => 'add']);
    Route::get('/view', ['as' => 'order.view', 'uses' => 'view']);
    Route::post('/store', ['as' => 'order.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'order.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'order.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'order.update', 'uses' => 'update']);
    Route::post('/{id}/updateStatus', ['as' => 'order.updateStatus', 'uses' => 'updateStatus']);
 });
});
