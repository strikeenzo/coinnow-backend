<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::get('updateDBField', function () {
    Schema::table('country', function (Blueprint $table) {
        $table->string('iso_code_2', 5)->change();
        $table->string('postcode_required', 50)->change();
    });
    DB::table('model_has_roles')->where('model_type', 'App\User')->update(['model_type' => 'App\Models\User']);
});

Route::get('/', function () {
    return view('frontend.welcome');
});
Route::get('/privacy-policy', function () {
    return view('frontend.privacy');
});
Route::group(['prefix' => 'admin'], function () {
    Auth::routes();
});

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        include ('AdminRoutes.php');
    });
});

//table to be upload
