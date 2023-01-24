<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/', 'AuthController@login');

Route::prefix('serverside')->group(function () {
    Route::get('location', 'ServerSideController@location');
});

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

        Route::prefix('religion')->group(function () {
            Route::get('/', 'ReligionController@index');
            Route::get('datatable', 'ReligionController@datatable');
            Route::post('create-data', 'ReligionController@createData');
            Route::get('show-data', 'ReligionController@showData');
            Route::patch('update-data', 'ReligionController@updateData');
            Route::delete('destroy-data', 'ReligionController@destroyData');
        });

        Route::prefix('unit')->group(function () {
            Route::get('/', 'UnitController@index');
            Route::get('datatable', 'UnitController@datatable');
            Route::post('create-data', 'UnitController@createData');
            Route::get('show-data', 'UnitController@showData');
            Route::patch('update-data', 'UnitController@updateData');
            Route::delete('destroy-data', 'UnitController@destroyData');
        });
    });

    Route::prefix('location')->namespace('Location')->group(function () {
        Route::prefix('province')->group(function () {
            Route::get('/', 'ProvinceController@index');
            Route::get('datatable', 'ProvinceController@datatable');
        });

        Route::prefix('city')->group(function () {
            Route::get('/', 'CityController@index');
            Route::get('datatable', 'CityController@datatable');
        });

        Route::prefix('district')->group(function () {
            Route::get('/', 'DistrictController@index');
            Route::get('datatable', 'DistrictController@datatable');
        });
    });

    Route::prefix('medical-record')->namespace('MedicalRecord')->group(function () {
        Route::prefix('patient')->group(function () {
            Route::get('/', 'PatientController@index');
            Route::get('datatable', 'PatientController@datatable');
            Route::get('show-data', 'PatientController@showData');
            Route::patch('update-data', 'PatientController@updateData');
            Route::delete('destroy-data', 'PatientController@destroyData');
            Route::get('print/{id}', 'PatientController@print');
        });

        Route::prefix('dtd')->group(function () {
            Route::get('/', 'DTDController@index');
            Route::get('datatable', 'DTDController@datatable');
            Route::post('create-data', 'DTDController@createData');
            Route::get('show-data', 'DTDController@showData');
            Route::patch('update-data', 'DTDController@updateData');
            Route::delete('destroy-data', 'DTDController@destroyData');
        });

        Route::prefix('icd')->group(function () {
            Route::get('/', 'ICDController@index');
            Route::get('datatable', 'ICDController@datatable');
            Route::post('create-data', 'ICDController@createData');
            Route::get('show-data', 'ICDController@showData');
            Route::patch('update-data', 'ICDController@updateData');
            Route::delete('destroy-data', 'ICDController@destroyData');
        });
    });

    Route::prefix('room')->namespace('Room')->group(function () {
        Route::prefix('data')->group(function () {
            Route::get('/', 'DataController@index');
            Route::get('datatable', 'DataController@datatable');
            Route::post('create-data', 'DataController@createData');
            Route::get('show-data', 'DataController@showData');
            Route::patch('update-data', 'DataController@updateData');
            Route::delete('destroy-data', 'DataController@destroyData');
        });

        Route::prefix('room-class')->group(function () {
            Route::get('/', 'RoomClassController@index');
            Route::get('datatable', 'RoomClassController@datatable');
            Route::post('create-data', 'RoomClassController@createData');
            Route::get('show-data', 'RoomClassController@showData');
            Route::patch('update-data', 'RoomClassController@updateData');
            Route::delete('destroy-data', 'RoomClassController@destroyData');
        });

        Route::prefix('room-space')->group(function () {
            Route::get('/', 'RoomSpaceController@index');
            Route::get('datatable', 'RoomSpaceController@datatable');
            Route::post('create-data', 'RoomSpaceController@createData');
            Route::get('show-data', 'RoomSpaceController@showData');
            Route::patch('update-data', 'RoomSpaceController@updateData');
            Route::delete('destroy-data', 'RoomSpaceController@destroyData');
        });

        Route::prefix('bed')->group(function () {
            Route::get('/', 'BedController@index');
            Route::get('datatable', 'BedController@datatable');
            Route::post('create-data', 'BedController@createData');
            Route::get('show-data', 'BedController@showData');
            Route::patch('update-data', 'BedController@updateData');
            Route::delete('destroy-data', 'BedController@destroyData');
        });
    });

    Route::prefix('action')->namespace('Action')->group(function () {
        Route::prefix('data')->group(function () {
            Route::get('/', 'DataController@index');
            Route::get('datatable', 'DataController@datatable');
            Route::post('create-data', 'DataController@createData');
            Route::get('show-data', 'DataController@showData');
            Route::patch('update-data', 'DataController@updateData');
            Route::delete('destroy-data', 'DataController@destroyData');
        });

        Route::prefix('other')->group(function () {
            Route::get('/', 'OtherController@index');
            Route::get('datatable', 'OtherController@datatable');
            Route::post('create-data', 'OtherController@createData');
            Route::get('show-data', 'OtherController@showData');
            Route::patch('update-data', 'OtherController@updateData');
            Route::delete('destroy-data', 'OtherController@destroyData');
        });

        Route::prefix('operative')->group(function () {
            Route::get('/', 'OperativeController@index');
            Route::get('datatable', 'OperativeController@datatable');
            Route::post('create-data', 'OperativeController@createData');
            Route::get('show-data', 'OperativeController@showData');
            Route::patch('update-data', 'OperativeController@updateData');
            Route::delete('destroy-data', 'OperativeController@destroyData');
        });

        Route::prefix('non-operative')->group(function () {
            Route::get('/', 'NonOperativeController@index');
            Route::get('datatable', 'NonOperativeController@datatable');
            Route::post('create-data', 'NonOperativeController@createData');
            Route::get('show-data', 'NonOperativeController@showData');
            Route::patch('update-data', 'NonOperativeController@updateData');
            Route::delete('destroy-data', 'NonOperativeController@destroyData');
        });

        Route::prefix('supporting')->group(function () {
            Route::get('/', 'SupportingController@index');
            Route::get('datatable', 'SupportingController@datatable');
            Route::post('create-data', 'SupportingController@createData');
            Route::get('show-data', 'SupportingController@showData');
            Route::patch('update-data', 'SupportingController@updateData');
            Route::delete('destroy-data', 'SupportingController@destroyData');
        });

        Route::prefix('emergency-care')->group(function () {
            Route::get('/', 'EmergencyCareController@index');
            Route::get('datatable', 'EmergencyCareController@datatable');
            Route::post('create-data', 'EmergencyCareController@createData');
            Route::get('show-data', 'EmergencyCareController@showData');
            Route::patch('update-data', 'EmergencyCareController@updateData');
            Route::delete('destroy-data', 'EmergencyCareController@destroyData');
        });
    });

    Route::prefix('operating-room')->namespace('OperatingRoom')->group(function () {
        Route::prefix('action')->group(function () {
            Route::get('/', 'ActionController@index');
            Route::get('datatable', 'ActionController@datatable');
            Route::post('create-data', 'ActionController@createData');
            Route::get('show-data', 'ActionController@showData');
            Route::patch('update-data', 'ActionController@updateData');
            Route::delete('destroy-data', 'ActionController@destroyData');
        });

        Route::prefix('action-type')->group(function () {
            Route::get('/', 'ActionTypeController@index');
            Route::get('datatable', 'ActionTypeController@datatable');
            Route::post('create-data', 'ActionTypeController@createData');
            Route::get('show-data', 'ActionTypeController@showData');
            Route::patch('update-data', 'ActionTypeController@updateData');
            Route::delete('destroy-data', 'ActionTypeController@destroyData');
        });

        Route::prefix('operating-group')->group(function () {
            Route::get('/', 'OperatingGroupController@index');
            Route::get('datatable', 'OperatingGroupController@datatable');
            Route::post('create-data', 'OperatingGroupController@createData');
            Route::get('show-data', 'OperatingGroupController@showData');
            Route::patch('update-data', 'OperatingGroupController@updateData');
            Route::delete('destroy-data', 'OperatingGroupController@destroyData');
        });

        Route::prefix('anesthetist')->group(function () {
            Route::get('/', 'AnesthetistController@index');
            Route::get('datatable', 'AnesthetistController@datatable');
            Route::post('create-data', 'AnesthetistController@createData');
            Route::get('show-data', 'AnesthetistController@showData');
            Route::patch('update-data', 'AnesthetistController@updateData');
            Route::delete('destroy-data', 'AnesthetistController@destroyData');
        });
    });

    Route::prefix('health-service')->namespace('HealthService')->group(function () {
        Route::prefix('pharmacy-production')->group(function () {
            Route::get('/', 'PharmacyProductionController@index');
            Route::get('datatable', 'PharmacyProductionController@datatable');
            Route::post('create-data', 'PharmacyProductionController@createData');
            Route::get('show-data', 'PharmacyProductionController@showData');
            Route::patch('update-data', 'PharmacyProductionController@updateData');
            Route::delete('destroy-data', 'PharmacyProductionController@destroyData');
        });

        Route::prefix('bed')->group(function () {
            Route::get('/', 'BedController@index');
            Route::get('datatable', 'BedController@datatable');
            Route::post('create-data', 'BedController@createData');
            Route::get('show-data', 'BedController@showData');
            Route::patch('update-data', 'BedController@updateData');
            Route::delete('destroy-data', 'BedController@destroyData');
        });
    });

    Route::prefix('poly')->namespace('Poly')->group(function () {
        Route::prefix('data')->group(function () {
            Route::get('/', 'DataController@index');
            Route::get('datatable', 'DataController@datatable');
            Route::post('create-data', 'DataController@createData');
            Route::get('show-data', 'DataController@showData');
            Route::patch('update-data', 'DataController@updateData');
            Route::delete('destroy-data', 'DataController@destroyData');
        });

        Route::prefix('action')->group(function () {
            Route::get('/', 'ActionController@index');
            Route::get('datatable', 'ActionController@datatable');
            Route::post('create-data', 'ActionController@createData');
            Route::get('show-data', 'ActionController@showData');
            Route::patch('update-data', 'ActionController@updateData');
            Route::delete('destroy-data', 'ActionController@destroyData');
        });
    });

    Route::prefix('lab')->namespace('Lab')->group(function () {
        Route::prefix('category')->group(function () {
            Route::get('/', 'CategoryController@index');
            Route::get('datatable', 'CategoryController@datatable');
            Route::post('create-data', 'CategoryController@createData');
            Route::get('show-data', 'CategoryController@showData');
            Route::patch('update-data', 'CategoryController@updateData');
            Route::delete('destroy-data', 'CategoryController@destroyData');
        });

        Route::prefix('item')->group(function () {
            Route::get('/', 'ItemController@index');
            Route::get('datatable', 'ItemController@datatable');
            Route::post('create-data', 'ItemController@createData');
            Route::get('show-data', 'ItemController@showData');
            Route::patch('update-data', 'ItemController@updateData');
            Route::delete('destroy-data', 'ItemController@destroyData');
        });

        Route::prefix('item-parent')->group(function () {
            Route::get('/', 'ItemParentController@index');
            Route::get('datatable', 'ItemParentController@datatable');
            Route::post('create-data', 'ItemParentController@createData');
            Route::get('show-data', 'ItemParentController@showData');
            Route::patch('update-data', 'ItemParentController@updateData');
            Route::delete('destroy-data', 'ItemParentController@destroyData');
        });
    });
});

Route::prefix('setting')->namespace('Setting')->group(function () {
    Route::prefix('role')->group(function () {
        Route::get('/', 'RoleController@index');
        Route::get('load-data', 'RoleController@loadData');
    });
});
