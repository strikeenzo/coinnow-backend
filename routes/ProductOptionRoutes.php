<?php
use App\Http\Controllers\Admin\ProductOptionController;

Route::group(['prefix' => 'product-option'], function () {
  Route::controller(ProductOptionController::class)->group(function () {
    Route::get('/', ['as' => 'product-option', 'uses' => 'index']);
    Route::get('/add', ['as' => 'product-option.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'product-option.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'product-option.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'product-option.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'product-option.update', 'uses' => 'update']);
 });
});
