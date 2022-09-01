<?php
use App\Http\Controllers\Admin\EnvController;

Route::group(['prefix' => 'env'], function () {
  Route::controller(EnvController::class)->group(function () {
    Route::get('/', ['as' => 'env','uses' => 'index']);
    Route::post('/', ['as' => 'env.update','uses' => 'update']);
  });
});
