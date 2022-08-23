<?php
use App\Http\Controllers\Admin\TaxRateController;

Route::group(['prefix' => 'tax-rate'], function () {
  Route::controller(TaxRateController::class)->group(function () {
    Route::get('/', ['as' => 'tax-rate', 'uses' => 'index']);
    Route::get('/add', ['as' => 'tax-rate.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'tax-rate.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'tax-rate.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'tax-rate.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'tax-rate.update', 'uses' => 'update']);
 });
});
