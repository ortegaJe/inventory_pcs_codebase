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

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('dashboard');

Route::prefix('admin/dashboard/inventario')->group(function () {

    Route::resource('/', 'App\Http\Controllers\Admin\AdminDashboardController')->names('admin.inventory.dash');

    Route::resource('de-escritorios', 'App\Http\Controllers\Computer\DesktopController')->names('admin.inventory.desktop');

    Route::resource('portatiles', 'App\Http\Controllers\Computer\LaptopController')->names('admin.inventory.laptop');

    Route::resource('tecnicos', 'App\Http\Controllers\Technician\TechnicianController')->names('admin.inventory.technicians');
});

Route::prefix('tecnico/costa/dashboard/inventario')->middleware('is_tec')->group(function () {

    Route::resource('/sede-macarena', 'App\Http\Controllers\Campu\Costa\MacarenaController')->names('admin.inventory.campu.macarena');
});

/*Route::get('/sp', function () {
    $serial = 'PC12345678';
    $inventory_number = 'XDF123';
    $status = 1;

    $sp = DB::select("EXEC sp_insert_pc " . $inventory_number . ", " . $serial . ", " . $status . "");
    dd($sp);
});*/

/*//Routes Desktop PC
Route::get('de-escritorios', 'DesktopController@indexAdminDesktop')->name('desktop_index');
//Route::post('registrar-pc-de-escritorios', [App\Http\Controllers\Computer\DesktopController::class, 'storeAdminDesktop'])->name('desktop_store');
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
*/
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
