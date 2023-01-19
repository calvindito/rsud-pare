<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/', 'AuthController@login');

Route::prefix('dashboard')->group(function () {
    Route::get('general', 'DashboardController@general');
});

Route::prefix('master-data')->namespace('MasterData')->group(function () {
    Route::prefix('general')->namespace('General')->group(function () {
        Route::prefix('class-type')->group(function () {
            Route::get('/', 'ClassTypeController@index');
            Route::get('datatable', 'ClassTypeController@datatable');
            Route::post('create-data', 'ClassTypeController@createData');
            Route::get('show-data', 'ClassTypeController@showData');
            Route::patch('update-data', 'ClassTypeController@updateData');
            Route::delete('destroy-data', 'ClassTypeController@destroyData');
        });
    });
});

Route::prefix('setting')->namespace('Setting')->group(function () {
    Route::prefix('role')->group(function () {
        Route::get('/', 'RoleController@index');
        Route::get('load-data', 'RoleController@loadData');
    });
});
