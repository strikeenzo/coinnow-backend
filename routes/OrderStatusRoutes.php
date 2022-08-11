<?php
use App\Http\Controllers\Admin\OrderStatusController;

Route::group(['prefix' => 'order-status'], function () {
  Route::controller(OrderStatusController::class)->group(function () {
    Route::get('/', ['as' => 'order-status', 'uses' => 'index']);
    Route::get('/add', ['as' => 'order-status.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'order-status.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'order-status.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'order-status.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'order-status.update', 'uses' => 'update']);
 });
});
