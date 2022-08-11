<?php
use App\Http\Controllers\Admin\BannerController;
Route::group(['prefix' => 'banner'], function () {
  Route::controller(BannerController::class)->group(function () {
    Route::get('/', ['as' => 'banner', 'uses' => 'index']);
    Route::get('/add', ['as' => 'banner.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'banner.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'banner.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'banner.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'banner.update', 'uses' => 'update']);
  });
});
