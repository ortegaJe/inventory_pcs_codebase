<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    //Routes All In One PC
    Route::get('data-all-in-one', 'AdminDashboardController@indexAio')->name('pcs.allinone_index');
    Route::get('registrar-pc-all-in-one', 'AdminDashboardController@createAllInOne')->name('pcs.allinone_create');
    Route::post('guardar-pc-all-in-one', 'AdminDashboardController@storeAllInOne')->name('pcs.allinone_store');

    //Routes Turnero PC
    Route::get('registrar-pc-turnero', 'AdminDashboardController@createTurnero')->name('pcs.turnero_create');
    Route::post('guardar-pc-turnero', 'AdminDashboardController@storeTurnero')->name('pcs.turnero_store');

    //Routes Raspberry PC
    Route::get('registrar-pc-raspberry', 'AdminDashboardController@createRaspberry')->name('pcs.raspberry_create');
    Route::post('guardar-pc-raspberry', 'AdminDashboardController@storeRaspberry')->name('pcs.raspberry_store');

    //Routes Laptop PC
    Route::get('registrar-pc-portatil', 'AdminDashboardController@createLaptop')->name('pcs.portatil_create');
    Route::post('guardar-pc-portatil', 'AdminDashboardController@storeLaptop')->name('pcs.portatil_store');
});

Route::get('example-faker', function () {
    return view('example');
});

Route::get('/tester', function () {

    $q = DB::table('first_storages')->pluck('id');

    foreach ($q as $query) {
        echo "[", $query, "]", ",";
    }

    return view('admin.test', ['query' => $query]);
});
