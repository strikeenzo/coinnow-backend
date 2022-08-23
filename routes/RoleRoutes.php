<?php
use App\Http\Controllers\Admin\RoleController;

Route::group(['prefix' => 'role'], function () {
  Route::controller(RoleController::class)->group(function () {
    Route::get('/', ['as' => 'role', 'uses' => 'index']);
    Route::get('/add', ['as' => 'role.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'role.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'role.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'role.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'role.update', 'uses' => 'update']);
 });
});
