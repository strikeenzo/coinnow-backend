<?php
use App\Http\Controllers\Admin\DealsOfTheDayController;

Route::group(['prefix' => 'trending_dod'], function () {
  Route::controller(DealsOfTheDayController::class)->group(function () {
    Route::get('/', ['as' => 'trending_dod', 'uses' => 'index']);
    Route::get('/add', ['as' => 'trending_dod.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'trending_dod.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'trending_dod.edit', 'uses' => 'edit']);
    Route::post('/{id}/update', ['as' => 'trending_dod.update', 'uses' => 'update']);
 });
});
