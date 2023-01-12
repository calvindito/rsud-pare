<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('dashboard/general');
});

Route::prefix('dashboard')->group(function() {
    Route::get('general', 'DashboardController@general');
});

Route::prefix('setting')->namespace('Setting')->group(function() {
    Route::prefix('role')->group(function() {
        Route::get('/', 'RoleController@index');
        Route::get('load-data', 'RoleController@loadData');
    });
});
