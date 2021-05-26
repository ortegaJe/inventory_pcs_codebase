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
    'prefix' => 'admin/dashboard/inventario',
    'as' => 'admin.inventario.',
    'namespace' => 'App\Http\Controllers\Admin',
    'middleware' => ['auth']
], function () {
    Route::resource('', 'AdminDashboardController');

    //Routes Desktop PC
    Route::get('de-escritorios', [App\Http\Controllers\Computer\DesktopController::class, 'indexAdminDesktop'])->name('desktop_index');
    Route::post('registrar-pc-de-escritorios', [App\Http\Controllers\Computer\DesktopController::class, 'storeAdminDesktop'])->name('desktop_store');
    //Route::delete('eliminar-pc-de-escritorios', [App\Http\Controllers\Computer\DesktopController::class, 'destroyAdminDesktop'])->name('desktop_destroy');

    //Routes All In One PC
    Route::get('all-in-one', 'AdminDashboardController@indexAio')->name('allinone_index');
    Route::get('registrar-pc-all-in-one', 'AdminDashboardController@createAllInOne')->name('allinone_create');
    Route::post('guardar-pc-all-in-one', 'AdminDashboardController@storeAllInOne')->name('allinone_store');

    //Routes Turnero PC
    Route::get('registrar-pc-turnero', 'AdminDashboardController@createTurnero')->name('turnero_create');
    Route::post('guardar-pc-turnero', 'AdminDashboardController@storeTurnero')->name('turnero_store');

    //Routes Raspberry PC
    Route::get('registrar-pc-raspberry', 'AdminDashboardController@createRaspberry')->name('raspberry_create');
    Route::post('guardar-pc-raspberry', 'AdminDashboardController@storeRaspberry')->name('raspberry_store');

    //Routes Laptop PC
    Route::get('registrar-pc-portatil', 'AdminDashboardController@createLaptop')->name('portatil_create');
    Route::post('guardar-pc-portatil', 'AdminDashboardController@storeLaptop')->name('portatil_store');
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
