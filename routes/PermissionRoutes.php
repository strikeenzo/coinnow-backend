<?php
use App\Http\Controllers\Admin\PermissionController;

Route::group(['prefix' => 'permission'], function () {
  Route::controller(PermissionController::class)->group(function () {
    Route::get('/', ['as' => 'permission', 'uses' => 'index']);
    Route::get('/add', ['as' => 'permission.add', 'uses' => 'add']);
    Route::post('/store', ['as' => 'permission.store', 'uses' => 'store']);
    Route::get('/{id}/edit', ['as' => 'permission.edit', 'uses' => 'edit']);
    Route::get('/{id}/delete]', ['as' => 'permission.delete', 'uses' => 'delete']);
    Route::post('/{id}/update', ['as' => 'permission.update', 'uses' => 'update']);
 });
});
