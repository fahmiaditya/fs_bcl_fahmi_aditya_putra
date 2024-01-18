<?php

use App\Http\Controllers\MyController;
use Illuminate\Support\Facades\Route;


Route::get('/', [MyController::class, 'login'])->name('login');
Route::post('/', [MyController::class, 'doLogin'])->name('doLogin');

Route::group(['middleware' => 'auth', 'prefix' => '/'], function ()
{
    Route::get('/dashboard',[MyController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout',[MyController::class, 'logout'])->name('logout');
});
