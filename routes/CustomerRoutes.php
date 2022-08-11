<?php
use App\Http\Controllers\Admin\CustomerController;

Route::group(['prefix' => 'customer'], function () {
  Route::controller(CustomerController::class)->group(function () {
    Route::get('/', ['as' => 'customer', 'uses' => 'index']);
    Route::get('/add', ['as' => 'customer.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'customer.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'customer.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'customer.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'customer.update', 'uses' => 'update']);
    Route::post('/detail', ['as' => 'customer.detail', 'uses' => 'getDetail']);
 });
});
