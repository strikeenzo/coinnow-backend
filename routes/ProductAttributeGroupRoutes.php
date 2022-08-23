<?php
use App\Http\Controllers\Admin\ProductAttributeGroupController;

Route::group(['prefix' => 'product-attribute-group'], function () {
  Route::controller(ProductAttributeGroupController::class)->group(function () {
    Route::get('/', ['as' => 'product-attribute-group', 'uses' => 'index']);
    Route::get('/add', ['as' => 'product-attribute-group.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'product-attribute-group.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'product-attribute-group.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'product-attribute-group.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'product-attribute-group.update', 'uses' => 'update']);
 });
});
