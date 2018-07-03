<?php

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

Route::middleware('auth')->get('/', 'HomeController@index')->name('index');

Route::namespace('System')->prefix('permissions')->as('system.permission.')->middleware(['auth','role'])->group(function() {
    Route::get('/', 'PermissionsController@index')->name('index');
    Route::get('/{permission}/getsidebars', 'PermissionsController@getSideBars')->name('getsidebars');
});
