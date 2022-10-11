<?php
use App\Http\Controllers\Admin\ButtonImageController;


Route::group(['prefix' => 'button'], function () {
  Route::controller(ButtonImageController::class)->group(function () {
    Route::get('/', ['as' => 'button', 'uses' => 'index']);
    Route::get('/add', ['as' => 'button.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'button.store', 'uses' => 'store']);
 });
});
