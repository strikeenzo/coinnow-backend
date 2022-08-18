<?php
use App\Http\Controllers\Admin\TradeController;


Route::group(['prefix' => 'trade'], function () {
  Route::controller(TradeController::class)->group(function () {
    Route::get('/', ['as' => 'trade', 'uses' => 'index']);
    Route::get('/add', ['as' => 'trade.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'trade.store', 'uses' => 'store']);
 });
});
