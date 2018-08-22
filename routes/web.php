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
//Route::get('/', function () {
//    return view('index');
//});

Auth::routes();

Route::middleware('auth')->get('/', 'HomeController@index')->name('index');
Route::middleware('auth')->get('/api', 'HomeController@api')->name('api');
Route::middleware('auth')->get('/test', 'HomeController@test')->name('test');
Route::middleware('auth')->get('/gateway', 'HomeController@gateway')->name('gateway');


Route::middleware(['auth','role','header'])->group(function() {

    Route::namespace('System')->group(function() {

        // 权限菜单
        Route::prefix('permission')->as('system.permission.')->group(function() {
            Route::put('/sort', 'PermissionsController@sort')->name('sort');
        });
        Route::as('system.')->group(function() {
            Route::resource('permission', 'PermissionsController')->except(['create', 'show']);
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

        // 清除缓存
        Route::prefix('cache')->as('system.cache.')->group(function() {
            Route::delete('/delete', 'CachesController@delete')->name('delete');
        });

    });


    Route::namespace('Item')->group(function() {
        // 现场管理
        Route::as('item.')->group(function() {
            Route::resource('project', 'ProjectsController')->except(['create']);
        });
        Route::as('item.')->group(function() {
            Route::post('project/findUnit', 'ProjectsController@findUnit')->name('project.find_unit');
            Route::post('project/form', 'ProjectsController@form')->name('project.form');
        });
    });

    Route::namespace('Unit')->group(function() {
        // 单位管理
        Route::as('unit.company.')->group(function() {
            Route::get('/unit', 'UnitsController@index')->name('index');
            Route::get('/unit/{unit}/edit', 'UnitsController@edit')->name('edit');
            Route::get('/unit/{unit}/find', 'UnitsController@find')->name('find');
            Route::put('/unit/{unit}', 'UnitsController@update')->name('update');
            Route::post('/unit', 'UnitsController@store')->name('store');
            Route::delete('/unit', 'UnitsController@destroy')->name('destroy');
            Route::post('/unit/export', 'UnitsController@export')->name('export');
            Route::post('/unit/import', 'UnitsController@import')->name('import');
            Route::post('/unit/form', 'UnitsController@form')->name('form');
        });

        // 单位类型管理
        Route::as('unit.')->group(function() {
            Route::get('utype/{utype}/option', 'UtypesController@option')->name('utype.option');
            Route::get('utype/searchoption', 'UtypesController@searchOption')->name('utype.searchOption');
        });

        Route::as('unit.')->group(function() {
            Route::resource('utype', 'UtypesController')->except(['show']);
        });
    });


    Route::namespace('Device')->group(function() {
        // 视频设备管理
        Route::as('device.')->group(function() {
            Route::post('video_device/address', 'VideoDeviceController@address');
            Route::resource('video_device', 'VideoDeviceController');
        });

        // 塔机设备管理
        Route::as('device.')->group(function() {
            Route::delete('crane', 'CraneController@destroy')->name('crane.destroy');
            Route::resource('crane', 'CraneController')->except(['create', 'show', 'destroy']);
        });

        Route::as('device.')->group(function() {
            Route::delete('dust', 'DustController@destroy')->name('dust.destroy');
            Route::resource('dust', 'DustController')->except(['create', 'show', 'destroy']);
        });
    });

    //监控管理
    Route::namespace('Video')->as('video.')->group(function() {
        //实时视频
        Route::as('current.')->group(function() {
            Route::get('/video/current', 'CurrentController@index')->name('index');
        });
    });

    // 萤石api
    Route::namespace('Ys')->as('ys.')->group(function() {
        Route::as('api.')->prefix('api')->group(function() {
            Route::post('/ys/post', 'YsController@post')->name('post');
            Route::post('/ys/get','YsController@get')->name('get');
        });

        Route::as('user.')->prefix('user')->group(function() {
            Route::post('/access_token/get', 'YsUsersController@accessToken')->name('access_token');
        });
    });
});


