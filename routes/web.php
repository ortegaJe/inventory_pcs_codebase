<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CampuController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\Inventory\GarbageController;
use App\Http\Controllers\User\Inventory\MiniPcController;
use App\Http\Controllers\User\Inventory\TabletController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/validar-firmas', [HomeController::class, 'ValidateSign'])->name('validate_sign');

Route::get('all-campus', [CampuController::class, 'getAllCampu'])->name('all_campus');

Route::get('campus-by-regional/{id?}', [CampuController::class, 'campuByRegional'])->name('campus.regional');

Route::get('select-category-devices', [HomeController::class, 'getCategoryDevice'])->name('select_category_device');

Route::get('search-devices', [HomeController::class, 'SearchDevice'])->name('search.device');

Route::get('auto-complete-serial-search', [HomeController::class, 'autoCompleteSerialSearch'])->name('auto_complete_serial');

//Route::get('sistemas-operativos-chart', [HomeController::class, 'getOsData'])->name('os_chart');

//Route::get('/equipos-en-prestamo', [HomeController::class, 'getBorrowedDeviceList'])->name('get_borrowed_list');

Route::prefix('admin/dashboard/inventario')->group(function () {

    Route::resource('/', 'App\Http\Controllers\Admin\AdminDashboardController')->names('admin.inventory.dash');

    Route::get('equipos-en-prestamo', [AdminDashboardController::class, 'getBorrowedDeviceList'])->name('get_borrowed_list');

    Route::get('sedes-con-menos-equipos', [AdminDashboardController::class, 'getCampusFewerDevices'])->name('get.campus.fewer.devices');

    Route::resource('tecnicos', 'App\Http\Controllers\Admin\UserController')->names('admin.inventory.technicians');

    Route::get('historial-tecnicos', [UserController::class, 'getAllUsers'])->name('technicians.history');

    Route::get('historial-cambios/{user_id}', [UserController::class, 'historyUser'])->name('technicians.history_changes');

    Route::get('perfil/{id?}', 'App\Http\Controllers\Admin\UserController@showProfileUser')->name('admin.inventory.technicians.profiles');

    Route::patch('actualizar-contrasenia-usuario/{id}', 'App\Http\Controllers\Admin\UserController@updatePassword')->name('admin.inventory.technicians.update-password');

    Route::patch('actualizar-sede-principal/{id}', 'App\Http\Controllers\Admin\UserController@updateCampu')->name('admin.inventory.technicians.update-campu');

    Route::patch('actualizar-cargo/{id}', 'App\Http\Controllers\Admin\UserController@updateProfile')->name('admin.inventory.technicians.update-profile');

    Route::patch('rol-asignado/{id}', 'App\Http\Controllers\Admin\UserController@updateRol')->name('admin.inventory.assingned-role');

    Route::resource('roles', 'App\Http\Controllers\Admin\RoleController')->names('admin.inventory.roles');

    Route::resource('sedes', 'App\Http\Controllers\Admin\CampuController')->names('admin.inventory.campus');

    Route::get('exports-campu-inventory-computers/{campuId}/{campu}', 'App\Http\Controllers\Admin\CampuController@exportCampu')->name('admin.inventory.export-campu-computers');

    Route::get('export-campu-by-regional/{regional?}', [CampuController::class, 'exportCampuByRegional'])->name('export.campu_by_regional');

    Route::get('export-all-campu-by-regional', [CampuController::class, 'exportAllCampuByRegional'])->name('export.all_campu_by_regional');
    
    Route::get('sedes-buscar', 'App\Http\Controllers\Admin\CampuController@autoCompleteSearch')->name('admin.inventory.campus.search');

    Route::get('usuarios-buscar', 'App\Http\Controllers\Admin\UserController@autoCompleteSearchUser')->name('admin.inventory.users.search');

    Route::post('asignar-tecnico-sede/{id}', 'App\Http\Controllers\Admin\CampuController@assingUserCampu')->name('admin.inventory.assing-user-campu');

    Route::delete('remover-tecnico-sede/{id}', 'App\Http\Controllers\Admin\CampuController@removeUserCampu')->name('admin.inventory.remove-user-campu');

    Route::get('maintenance/sede={id?}', 'App\Http\Controllers\Admin\AdminDashboardController@maintenanceView')->name('admin.inventory.maintenance');

    Route::get('coming-soon/{id}', 'App\Http\Controllers\Admin\AdminDashboardController@comingSoonView')->name('admin.inventory.coming-soon');

    Route::get('exports-all-inventory-computers', 'App\Http\Controllers\Admin\AdminDashboardController@exportComputers')->name('admin.inventory.export-all-computers');

    Route::get('firmas-administradores', 'App\Http\Controllers\Admin\AdminDashboardController@createAdminSignature')->name('admin.inventory.admin-signatures.create');

    Route::post('guardar-firmas-administradores', 'App\Http\Controllers\Admin\AdminDashboardController@storeAdminSignature')->name('admin.inventory.admin-signatures.store');

    Route::get('stock', [AdminDashboardController::class, 'getStock'])->name('get.stock');
});

Route::prefix('tecnico/dashboard/inventario')->group(function () {

    Route::resource('de-escritorios', 'App\Http\Controllers\User\Inventory\DesktopController')->names('user.inventory.desktop');

    Route::resource('portatiles', 'App\Http\Controllers\User\Inventory\LaptopController')->names('user.inventory.laptop');

    Route::resource('all-in-one', 'App\Http\Controllers\User\Inventory\AllInOneController')->names('user.inventory.allinone');

    Route::resource('turneros', 'App\Http\Controllers\User\Inventory\TurneroController')->names('user.inventory.turnero');

    Route::resource('raspberry', 'App\Http\Controllers\User\Inventory\RaspberryController')->names('user.inventory.raspberry');

    Route::resource('telefonos-ip', 'App\Http\Controllers\User\Inventory\PhoneIpController')->names('user.inventory.phones');

    Route::resource('mini-pc-sat', MiniPcController::class)->names('minipc');

    Route::resource('tablets', TabletController::class)->names('tablet');
    
    Route::put('cargar-firma-tecnico/{id}', 'App\Http\Controllers\Admin\UserController@uploadUserSign')->name('upload.sign.user');

    //Route::put('actualizar-firma-tecnico/{id}', 'App\Http\Controllers\Admin\UserController@updateUserSign')->name('update.sign.user');

    Route::get('equipos-eliminados', [GarbageController::class, 'getDevicesList'])->name('get.devices.list');

    Route::post('restaurar-equipo', [GarbageController::class, 'retoreDevice'])->name('restore.device');

    Route::post('restaurar-equipos-seleccionados', [GarbageController::class, 'restoreSelectedDevices'])->name('restore.selected.devices');
});

Route::prefix('dashboard/inventario/reportes')->group(
    function () {
        Route::get('', 'App\Http\Controllers\Admin\ReportController@index')->name('inventory.report.index');

        Route::get('de-baja', 'App\Http\Controllers\Admin\ReportController@indexReportRemove')->name('inventory.report.removes.index');

        Route::get('de-baja/{device}-{uuid}', 'App\Http\Controllers\Admin\ReportController@createReportRemove')->name('inventory.report.removes.create');

        Route::post('guardar-reporte-de-baja', 'App\Http\Controllers\Admin\ReportController@storeReportRemove')->name('inventory.report.removes.store');

        Route::get('de-baja-generado/{device}-{uuid}', 'App\Http\Controllers\Admin\ReportController@reportRemoveGenerated')->name('inventory.report.removes.generated');

        Route::get('mantenimientos', 'App\Http\Controllers\Admin\ReportController@indexReportMaintenance')->name('inventory.report.maintenance.index');

        Route::get('descargar-mantenimiento-sede', 'App\Http\Controllers\Admin\ReportController@downloadMtoCampu')->name('inventory.report.download.mto.campu');

        Route::get('/mto/getCampus', [MaintenanceController::class, 'getCampusMto'])->name('get.campus.mto');
        
        Route::post('/mto/mtoDownload', [MaintenanceController::class, 'downloadMto'])->name('download.mto');

        Route::get('mantenimientos/{device_id}-{device_rowguid}', 'App\Http\Controllers\Admin\ReportController@createReportMaintenance')->name('inventory.report.maintenance.create');

        Route::post('guardar-reporte-de-mantenimiento', 'App\Http\Controllers\Admin\ReportController@storeReportMaintenance')->name('inventory.report.maintenance.store');

        Route::get('mantenimiento-generado/{report_id?}-{uuid?}', 'App\Http\Controllers\Admin\ReportController@reportMaintenanceGenerated')->name('inventory.report.maintenance.generated');

        Route::get('acta-de-entrega', 'App\Http\Controllers\Admin\ReportController@indexReportDelivery')->name('inventory.report.delivery.index');

        Route::get('acta-de-entrega/{device_id}/{rowguid}', 'App\Http\Controllers\Admin\ReportController@createReportDelivery')->name('report.delivery.create');

        Route::post('guardar-reporte-de-acta-de-entrega', 'App\Http\Controllers\Admin\ReportController@storeReportDelivery')->name('inventory.report.deliverys.store');

        Route::get('acta-de-entrega-generado/{device}/{uuid}', 'App\Http\Controllers\Admin\ReportController@reportDeliveryGenerated')->name('report.delivery.generated');

        Route::post('cargar-acta-de-entrega-firmado/{report_id}/{device_id}', 'App\Http\Controllers\Admin\ReportController@uploadFileReportDeliverySigned')->name('upload.file.delivery');

        Route::get('descargar-excel', [ReportController::class, 'indexExcelReportDevice'])->name('index.excel.report.device');

        Route::get('download-report-excel-devices/{id?}', [ReportController::class, 'downloadExcelReportDevice'])->name('download.excel.report.device');
        
        Route::get('download-report-excel-all-devices/{user?}', [ReportController::class, 'downloadExcelReportAllDevice'])->name('download.excel.report.all.device');
        
        Route::get('firmas-administradores', 'App\Http\Controllers\Admin\ReportController@indexSign')->name('sign.index');

        Route::get('editar-administrador-sede/{id}-{slug}', 'App\Http\Controllers\Admin\ReportController@editSign')->name('sign.edit');

        Route::put('actualizar-administrador-sede/{id}', 'App\Http\Controllers\Admin\ReportController@updateSign')->name('sign.update');

        Route::get('validate-calendar-mto', [ReportController::class, 'validateCalendarMto'])->name('calendar_mto');
    }
);

Route::get('example-faker', function () {
    return view('example');
});

Route::get('error_400', function () {
    return view('layouts.op_error_400');
})->name('inventory.error');
