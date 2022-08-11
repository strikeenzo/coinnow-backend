<?php
use App\Http\Controllers\Admin\ShippingController;

Route::group(['prefix' => 'shipping'], function () {
  Route::controller(ShippingController::class)->group(function () {
    Route::get('/', ['as' => 'shipping', 'uses' => 'index']);
    Route::get('/add', ['as' => 'shipping.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'shipping.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'shipping.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'shipping.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'shipping.update', 'uses' => 'update']);
 });
});
