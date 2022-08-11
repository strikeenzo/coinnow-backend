<?php
use App\Http\Controllers\Admin\CategoryController;

Route::group(['prefix' => 'category'], function () {
  Route::controller(CategoryController::class)->group(function () {
    Route::get('/', ['as' => 'category','uses' => 'index']);
    Route::get('/add', ['as' => 'category.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'category.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'category.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'category.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'category.update', 'uses' => 'update']);
  });
});
