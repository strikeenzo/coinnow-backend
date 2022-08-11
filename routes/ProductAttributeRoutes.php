<?php
use App\Http\Controllers\Admin\ProductAttributeController;

Route::group(['prefix' => 'product-attribute'], function () {
  Route::controller(ProductAttributeController::class)->group(function () {
    Route::get('/', ['as' => 'product-attribute', 'uses' => 'index']);
    Route::get('/add', ['as' => 'product-attribute.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'product-attribute.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'product-attribute.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'product-attribute.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'product-attribute.update', 'uses' => 'update']);
 });
});
