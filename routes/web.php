<?php

use App\Models\User;
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

    Route::resource('roles', 'App\Http\Controllers\Admin\RoleController')->names('admin.inventory.roles');

    Route::resource('sedes', 'App\Http\Controllers\Admin\CampuController')->names('admin.inventory.campus');

    Route::get('sedes/check_slug', 'App\Http\Controllers\Admin\CampuController@checkSlug')->name('admin.inventory.campus.slug');
});

Route::prefix('tecnico/dashboard/inventario/costa')->group(function () {

    Route::resource('de-escritorios', 'App\Http\Controllers\Tecnico\Inventario\DesktopController')->names('user.inventory.desktop');

    Route::resource('portatiles', 'App\Http\Controllers\Tecnico\Inventario\LaptopController')->names('user.inventory.laptop');

    Route::resource('all-in-one', 'App\Http\Controllers\Tecnico\Inventario\AllinOneController')->names('user.inventory.allinone');

    Route::resource('turneros', 'App\Http\Controllers\Tecnico\Inventario\TurneroController')->names('user.inventory.turnero');

    Route::resource('raspberry', 'App\Http\Controllers\Tecnico\Inventario\RaspberryController')->names('user.inventory.raspberry');
});

Route::get('example-faker', function () {
    return view('example');
});
