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

    Route::resource('tecnicos', 'App\Http\Controllers\Admin\UserController')->names('admin.inventory.technicians');

    Route::patch('actualizar-contrasenia-usuario/{id}', 'App\Http\Controllers\Admin\UserController@updatePassword')->name('admin.inventory.technicians.update-password');

    Route::patch('actualizar-sede-principal/{id}', 'App\Http\Controllers\Admin\UserController@updateCampu')->name('admin.inventory.technicians.update-campu');

    Route::patch('actualizar-cargo/{id}', 'App\Http\Controllers\Admin\UserController@updateProfile')->name('admin.inventory.technicians.update-profile');

    Route::patch('rol-asignado/{id}', 'App\Http\Controllers\Admin\UserController@updateRol')->name('admin.inventory.assingned-role');

    Route::resource('roles', 'App\Http\Controllers\Admin\RoleController')->names('admin.inventory.roles');

    Route::resource('sedes', 'App\Http\Controllers\Admin\CampuController')->names('admin.inventory.campus');

    Route::get('sedes-buscar', 'App\Http\Controllers\Admin\CampuController@autocompleteSearch')->name('admin.inventory.campus.buscar');

    Route::post('asignar-tecnico-sede', 'App\Http\Controllers\Admin\CampuController@assingUserCampu')->name('admin.inventory.assing-user-campu');
});

Route::prefix('tecnico/dashboard/inventario')->group(function () {

    Route::resource('de-escritorios', 'App\Http\Controllers\User\Inventario\DesktopController')->names('user.inventory.desktop');

    Route::resource('portatiles', 'App\Http\Controllers\User\Inventario\LaptopController')->names('user.inventory.laptop');

    Route::resource('all-in-one', 'App\Http\Controllers\User\Inventario\AllInOneController')->names('user.inventory.allinone');

    Route::resource('turneros', 'App\Http\Controllers\User\Inventario\TurneroController')->names('user.inventory.turnero');

    Route::resource('raspberry', 'App\Http\Controllers\User\Inventario\RaspberryController')->names('user.inventory.raspberry');
});

Route::get('example-faker', function () {
    return view('example');
});
