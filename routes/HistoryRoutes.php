<?php
use App\Http\Controllers\Admin\HistoryController;

Route::group(['prefix' => 'history'], function () {
  Route::controller(HistoryController::class)->group(function () {
    Route::get('/', ['as' => 'history','uses' => 'index']);
  });
});
