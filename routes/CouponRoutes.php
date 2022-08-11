<?php
use App\Http\Controllers\Admin\CouponController;

Route::group(['prefix' => 'coupon'], function () {
  Route::controller(CouponController::class)->group(function () {
    Route::get('/', ['as' => 'coupon', 'uses' => 'index']);
    Route::get('/add', ['as' => 'coupon.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'coupon.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'coupon.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'coupon.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'coupon.update', 'uses' => 'update']);
  });
});
