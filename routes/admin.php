<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;

Route::group([
    'prefix' => '/Dashboard',
    'as' => 'admin.',
    'namespace' => 'App\Http\Controllers\Admin',
    //'middleware' => ['auth', 'admin']
], function () {
Route::resource('Computers', 'AdminDashboardController');

});

