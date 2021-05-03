<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::group([
    'prefix' => 'admin/dashboard',
    'as' => 'admin.',
    'namespace' => 'App\Http\Controllers\Admin',
    'middleware' => ['auth']
], function () {
    Route::resource('pcs', 'AdminDashboardController');
    Route::get('registrar-pc-all-in-one', 'AdminDashboardController@createAllInOne')->name('pcs.create_allinone');
    Route::post('guardar-pc-all-in-one', 'AdminDashboardController@storeAllInOne')->name('pcs.store_allinone');
});

Route::get('example-faker', function () {
    return view('example');
});
