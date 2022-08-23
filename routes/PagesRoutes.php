<?php
use App\Http\Controllers\Admin\PagesController;

Route::group(['prefix' => 'pages'], function () {
  Route::controller(PagesController::class)->group(function () {
    Route::get('/', ['as' => 'pages', 'uses' => 'index']);
    Route::get('/add', ['as' => 'pages.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'pages.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'pages.edit', 'uses' => 'edit']);
    Route::post('/{id}/update', ['as' => 'pages.update', 'uses' => 'update']);
  });
});
