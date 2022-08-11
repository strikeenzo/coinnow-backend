<?php
use App\Http\Controllers\Admin\CountryController;

Route::group(['prefix' => 'country'], function () {
  Route::controller(CountryController::class)->group(function () {
    Route::get('/', ['as' => 'country', 'uses' => 'index']);
    Route::get('/add', ['as' => 'country.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'country.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'country.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'country.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'country.update', 'uses' => 'update']);
  });
});
