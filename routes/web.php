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
Route::middleware('auth')->get('/api', 'HomeController@api')->name('api');

Route::middleware(['auth','role','header'])->group(function() {

    Route::namespace('System')->group(function() {

        // 权限菜单
        Route::prefix('permissions')->as('system.permission.')->group(function() {
            Route::get('/', 'PermissionsController@index')->name('index');
            Route::get('/{permission}/getsidebars', 'PermissionsController@getSideBars')->name('getsidebars');
        });

        // 用户
        Route::prefix('user')->as('system.user.')->group(function() {
            Route::get('/', 'UsersController@index')->name('index');
            Route::get('/get_roles', 'UsersController@getRoles')->name('get_roles');
            Route::post('/', 'UsersController@store')->name('store');
            Route::get('/{user}', 'UsersController@edit')->name('edit');
            Route::patch('/{user}', 'UsersController@update')->name('update');
            Route::delete('/', 'UsersController@destroy')->name('destroy');
        });

        // 用户组
        Route::prefix('role')->as('system.role.')->group(function() {
            Route::get('/', 'RolesController@index')->name('index');
            Route::post('/', 'RolesController@store')->name('store');
            Route::patch('/{role}', 'RolesController@update')->name('update');
            Route::delete('/', 'RolesController@destroy')->name('destroy');
            Route::get('/{role}/permission', 'RolesController@editPermission')->name('edit_permission');
            Route::put('/{role}/permission', 'RolesController@updatePermission')->name('update_permission');
        });

    });
});


