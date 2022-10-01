<?php
use App\Http\Controllers\Admin\CoinPriceController;


Route::group(['prefix' => 'payment'], function () {
  Route::controller(CoinPriceController::class)->group(function () {
    Route::get('/', ['as' => 'coinPrice', 'uses' => 'index']);
    Route::get('/history', ['as' => 'coinPrice.paymentHistory', 'uses' => 'paymentHistory']);
    Route::get('/{id}', ['as' => 'coinPrice.edit', 'uses' => 'edit']);
    Route::post('/{id}', ['as' => 'coinPrice.update', 'uses' => 'update']);
 });
});
