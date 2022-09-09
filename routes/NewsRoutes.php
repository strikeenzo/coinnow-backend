<?php
use App\Http\Controllers\Admin\NewsController;


Route::group(['prefix' => 'news'], function () {
  Route::controller(NewsController::class)->group(function () {
    Route::get('/', ['as' => 'news', 'uses' => 'index']);
    Route::get('/add', ['as' => 'news.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'news.store', 'uses' => 'store']);
    Route::get('/{id}', ['as' => 'news.edit', 'uses' => 'edit']);
    Route::post('/{id}', ['as' => 'news.update', 'uses' => 'update']);
    Route::get('/{id}/delete', ['as' => 'news.delete', 'uses' => 'delete']);
 });
});
