<?php
use App\Http\Controllers\Admin\ClanController;


Route::group(['prefix' => 'clan'], function () {
  Route::controller(ClanController::class)->group(function () {
    Route::get('/', ['as' => 'clan', 'uses' => 'index']);
    Route::get('/add/{id}', ['as' => 'clan.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'clan.store', 'uses' => 'store']);
    Route::post('/{id}', ['as' => 'clan.update', 'uses' => 'update']);
    Route::get('/{id}', ['as' => 'clan.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete', ['as' => 'clan.delete', 'uses' => 'delete']);
 });
});
