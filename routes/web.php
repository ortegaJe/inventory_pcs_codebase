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

    Route::get('perfil/{id?}', 'App\Http\Controllers\Admin\UserController@showProfileUser')->name('admin.inventory.technicians.profiles');

    Route::patch('actualizar-contrasenia-usuario/{id}', 'App\Http\Controllers\Admin\UserController@updatePassword')->name('admin.inventory.technicians.update-password');

    Route::patch('actualizar-sede-principal/{id}', 'App\Http\Controllers\Admin\UserController@updateCampu')->name('admin.inventory.technicians.update-campu');

    Route::patch('actualizar-cargo/{id}', 'App\Http\Controllers\Admin\UserController@updateProfile')->name('admin.inventory.technicians.update-profile');

    Route::patch('rol-asignado/{id}', 'App\Http\Controllers\Admin\UserController@updateRol')->name('admin.inventory.assingned-role');

    Route::resource('roles', 'App\Http\Controllers\Admin\RoleController')->names('admin.inventory.roles');

    Route::resource('sedes', 'App\Http\Controllers\Admin\CampuController')->names('admin.inventory.campus');

    Route::get('exports-campu-inventory-computers-{id}-{slug}', 'App\Http\Controllers\Admin\CampuController@exportCampu')->name('admin.inventory.export-campu-computers');

    Route::get('sedes-buscar', 'App\Http\Controllers\Admin\CampuController@autoCompleteSearch')->name('admin.inventory.campus.search');

    Route::get('usuarios-buscar', 'App\Http\Controllers\Admin\UserController@autoCompleteSearchUser')->name('admin.inventory.users.search');

    Route::post('asignar-tecnico-sede/{id}', 'App\Http\Controllers\Admin\CampuController@assingUserCampu')->name('admin.inventory.assing-user-campu');

    Route::delete('remover-tecnico-sede/{id}', 'App\Http\Controllers\Admin\CampuController@removeUserCampu')->name('admin.inventory.remove-user-campu');

    Route::get('maintenance/sede={id?}', 'App\Http\Controllers\Admin\AdminDashboardController@maintenanceView')->name('admin.inventory.maintenance');

    Route::get('coming-soon/{id}', 'App\Http\Controllers\Admin\AdminDashboardController@comingSoonView')->name('admin.inventory.coming-soon');

    Route::get('exports-all-inventory-computers', 'App\Http\Controllers\Admin\AdminDashboardController@exportComputers')->name('admin.inventory.export-all-computers');
});

Route::prefix('tecnico/dashboard/inventario')->group(function () {

    Route::resource('de-escritorios', 'App\Http\Controllers\User\Inventory\DesktopController')->names('user.inventory.desktop');

    Route::resource('portatiles', 'App\Http\Controllers\User\Inventory\LaptopController')->names('user.inventory.laptop');

    Route::resource('all-in-one', 'App\Http\Controllers\User\Inventory\AllInOneController')->names('user.inventory.allinone');

    Route::resource('turneros', 'App\Http\Controllers\User\Inventory\TurneroController')->names('user.inventory.turnero');

    Route::resource('raspberry', 'App\Http\Controllers\User\Inventory\RaspberryController')->names('user.inventory.raspberry');

    Route::resource('telefonos-ip', 'App\Http\Controllers\User\Inventory\PhoneIpController')->names('user.inventory.phones');
});

Route::prefix('dashboard/inventario/reportes')->group(
    function () {
        Route::get('', 'App\Http\Controllers\Admin\ReportController@getReport')->name('inventory.report.index');

        Route::get('solicitud-de-baja', 'App\Http\Controllers\Admin\ReportController@indexReportRemove')->name('inventory.report.removes.index');

        Route::get('solicitud-de-baja/{id}-{uuid}', 'App\Http\Controllers\Admin\ReportController@createReportRemove')->name('inventory.report.removes.create');

        Route::post('guardar-reporte-de-baja', 'App\Http\Controllers\Admin\ReportController@storeReportRemove')->name('inventory.report.removes.store');

        Route::get('de-baja-generado/{id}', 'App\Http\Controllers\Admin\ReportController@reportRemoveGenerated')->name('inventory.report.removes.generated');

        Route::get('hoja-de-vida', 'App\Http\Controllers\Admin\ReportController@indexReportResume')->name('inventory.report.resumes.index');

        Route::get('hoja-de-vida/{id}-{uuid}', 'App\Http\Controllers\Admin\ReportController@createReportResume')->name('inventory.report.resumes.create');

        Route::post('guardar-reporte-hoja-de-vida', 'App\Http\Controllers\Admin\ReportController@storeReportResume')->name('inventory.report.resumes.store');

        Route::get('hoja-de-vida-generado/{id}', 'App\Http\Controllers\Admin\ReportController@reportResumeGenerated')->name('inventory.report.resumes.generated');

        Route::post('guardar-reporte-mantenimiento', 'App\Http\Controllers\Admin\ReportController@storeReportMaintenance')->name('inventory.report.maintenance.store');

        Route::get('mantenimiento-generado/{id}', 'App\Http\Controllers\Admin\ReportController@reportMaintenanceGenerated')->name('inventory.report.maintenance.generated');

        Route::get('acta-de-entrega', 'App\Http\Controllers\Admin\ReportController@indexReportDelivery')->name('inventory.report.delivery.index');

        //Route::get('reporte-de-acta-de-entrega/{id}-{uuid}', 'App\Http\Controllers\Admin\ReportController@createReportDelivery')->name('inventory.report.removes.create');

        //Route::post('guardar-reporte-de-baja', 'App\Http\Controllers\Admin\ReportController@storeReportRemove')->name('inventory.report.removes.store');

        //Route::get('reporte-de-baja-generado/{id}', 'App\Http\Controllers\Admin\ReportController@reportRemoveGenerated')->name('inventory.report.removes.generated');

        Route::get('public-file/{id}', 'App\Http\Controllers\Admin\ReportController@pdfReportResumes')->name('inventory.report.resumes.pdf');
    }
);

Route::get('example-faker', function () {
    return view('example');
});
