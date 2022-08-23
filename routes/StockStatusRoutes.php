<?php
use App\Http\Controllers\Admin\StockStatusController;

Route::group(['prefix' => 'stock-status'], function () {
  Route::controller(StockStatusController::class)->group(function () {
    Route::get('/', ['as' => 'stock-status', 'uses' => 'index']);
    Route::get('/add', ['as' => 'stock-status.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'stock-status.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'stock-status.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'stock-status.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'stock-status.update', 'uses' => 'update']);
 });
});
