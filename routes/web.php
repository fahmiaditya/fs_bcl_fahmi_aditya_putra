<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArmadaController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\JenisArmadaController;

Route::get('/', [MyController::class, 'login'])->name('login');
Route::post('/', [MyController::class, 'doLogin'])->name('doLogin');

Route::group(['middleware' => 'auth', 'prefix' => '/'], function ()
{
    Route::get('/dashboard',[MyController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout',[MyController::class, 'logout'])->name('logout');

    // MODULE USER
    Route::resource('/users', UserController::class);
    Route::post('/users/load-data', [UserController::class, 'loadData'])->name('users.load-data');
    Route::post('/users/delete', [UserController::class, 'delete'])->name('users.delete')->middleware(['permission:delete_users']);
    Route::post('/users/load-role/filter', [UserController::class, 'loadRole'])->name('users.load-role');

    // MODULE ROLE
    Route::resource('/roles', RoleController::class);
    Route::post('/roles/load-data', [RoleController::class, 'loadData'])->name('roles.load-data');

    // MODULE JENIS ARMADA
    Route::resource('/jenis-armada', JenisArmadaController::class);
    Route::post('/jenis-armada/load-data', [JenisArmadaController::class, 'loadData'])->name('jenis-armada.load-data');
    Route::post('/jenis-armada/delete', [JenisArmadaController::class, 'delete'])->name('jenis-armada.delete')->middleware(['permission:delete_jenis-armada']);
    Route::post('/jenis-armada/show-combobox', [JenisArmadaController::class, 'showCombobox'])->name('jenis-armada.show-combobox');

    // MODULE CUSTOMER
    Route::resource('/customer', CustomerController::class);
    Route::post('/customer/load-data', [CustomerController::class, 'loadData'])->name('customer.load-data');
    Route::post('/customer/delete', [CustomerController::class, 'delete'])->name('customer.delete')->middleware(['permission:delete_customer']);

    // MODULE ARMADA
    Route::resource('/armada', ArmadaController::class);
    Route::post('/armada/load-data', [ArmadaController::class, 'loadData'])->name('armada.load-data');
    Route::post('/armada/delete', [ArmadaController::class, 'delete'])->name('armada.delete')->middleware(['permission:delete_armada']);
    Route::post('/armada/load-data/modal', [ArmadaController::class, 'loadDataModal'])->name('armada.load-data.modal');

    // MODULE TRANSAKSI
    Route::resource('/transaksi', TransaksiController::class);
    Route::post('/transaksi/load-data', [TransaksiController::class, 'loadData'])->name('transaksi.load-data');
    Route::post('/transaksi/delete', [TransaksiController::class, 'delete'])->name('transaksi.delete')->middleware(['permission:delete_transaksi']);
});
