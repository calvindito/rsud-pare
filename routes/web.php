<?php

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/', 'AuthController@login');

Route::get('demo', function () {
    return view('layouts.index', [
        'data' => [
            'title' => 'Demo Form Sementara',
            'faker' => Faker::create('id_ID'),
            'content' => 'demo'
        ]
    ]);
});

Route::prefix('dashboard')->group(function () {
    Route::get('general', 'DashboardController@general');
});

Route::prefix('patient')->namespace('Patient')->group(function () {
    Route::prefix('register')->group(function () {
        Route::get('/', 'RegisterController@index');
    });
});

Route::prefix('setting')->namespace('Setting')->group(function () {
    Route::prefix('role')->group(function () {
        Route::get('/', 'RoleController@index');
        Route::get('load-data', 'RoleController@loadData');
    });
});
