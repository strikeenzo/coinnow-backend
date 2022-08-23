<?php
use App\Http\Controllers\Admin\ProductController;

Route::group(['prefix' => 'product'], function () {
  Route::controller(ProductController::class)->group(function () {
    Route::get('/', ['as' => 'product', 'uses' => 'index']);
    Route::get('/add', ['as' => 'product.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'product.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'product.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'product.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'product.update', 'uses' => 'update']);
    Route::post('/detail', ['as' => 'product.detail', 'uses' => 'getDetail']);
 });
});
