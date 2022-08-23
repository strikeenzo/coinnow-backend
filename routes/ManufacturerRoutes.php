<?php
use App\Http\Controllers\Admin\ManufacturerController;

Route::group(['prefix' => 'manufacturer'], function () {
  Route::controller(ManufacturerController::class)->group(function () {
    Route::get('/', ['as' => 'manufacturer', 'uses' => 'index']);
    Route::get('/add', ['as' => 'manufacturer.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'manufacturer.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'manufacturer.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'manufacturer.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'manufacturer.update', 'uses' => 'update']);
 });
});
