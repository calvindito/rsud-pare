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

        Route::prefix('doctor')->group(function () {
            Route::get('/', 'DoctorController@index');
            Route::get('datatable', 'DoctorController@datatable');
            Route::post('create-data', 'DoctorController@createData');
            Route::get('show-data', 'DoctorController@showData');
            Route::patch('update-data', 'DoctorController@updateData');
            Route::delete('destroy-data', 'DoctorController@destroyData');
        });

        Route::prefix('employee')->group(function () {
            Route::get('/', 'EmployeeController@index');
            Route::get('datatable', 'EmployeeController@datatable');
            Route::post('create-data', 'EmployeeController@createData');
            Route::get('show-data', 'EmployeeController@showData');
            Route::patch('update-data', 'EmployeeController@updateData');
            Route::delete('destroy-data', 'EmployeeController@destroyData');
        });

        Route::prefix('medical-service')->group(function () {
            Route::get('/', 'MedicalServiceController@index');
            Route::get('datatable', 'MedicalServiceController@datatable');
            Route::post('create-data', 'MedicalServiceController@createData');
            Route::get('show-data', 'MedicalServiceController@showData');
            Route::patch('update-data', 'MedicalServiceController@updateData');
            Route::delete('destroy-data', 'MedicalServiceController@destroyData');
        });

        Route::prefix('patient-group')->group(function () {
            Route::get('/', 'PatientGroupController@index');
            Route::get('datatable', 'PatientGroupController@datatable');
            Route::post('create-data', 'PatientGroupController@createData');
            Route::get('show-data', 'PatientGroupController@showData');
            Route::patch('update-data', 'PatientGroupController@updateData');
            Route::delete('destroy-data', 'PatientGroupController@destroyData');
        });
    });
});

Route::prefix('setting')->namespace('Setting')->group(function () {
    Route::prefix('role')->group(function () {
        Route::get('/', 'RoleController@index');
        Route::get('load-data', 'RoleController@loadData');
    });
});
