<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/', 'AuthController@login');

Route::middleware('auth')->group(function () {
    Route::get('index', function () {
        return view('layouts.index', [
            'data' => [
                'time' => date('G', time()),
                'content' => 'index'
            ]
        ]);
    });

    Route::prefix('auth')->group(function () {
        Route::match(['get', 'post'], 'profile', 'AuthController@profile');
        Route::match(['get', 'post'], 'change-password', 'AuthController@changePassword');
        Route::get('logout', 'AuthController@logout');
    });

    Route::prefix('serverside')->group(function () {
        Route::get('location', 'ServerSideController@location');
        Route::get('patient', 'ServerSideController@patient');
        Route::get('medicine', 'ServerSideController@medicine');
    });

    Route::middleware('verify.permission')->group(function () {
        Route::prefix('dashboard')->namespace('Dashboard')->group(function () {
            Route::prefix('visit')->group(function () {
                Route::get('/', 'VisitController@index');
                Route::get('per-year', 'VisitController@perYear');
                Route::get('last-3-year', 'VisitController@last3Year');
                Route::get('last-5-year', 'VisitController@last5Year');
                Route::get('outpatient', 'VisitController@outpatient');
                Route::get('inpatient', 'VisitController@inpatient');
                Route::get('emergency-department', 'VisitController@emergencyDepartment');
            });

            Route::prefix('general')->group(function () {
                Route::get('/', 'GeneralController@general');
            });

            Route::prefix('poly')->group(function () {
                Route::get('/', 'PolyController@general');
            });
        });

        Route::prefix('master-data')->namespace('MasterData')->group(function () {
            Route::prefix('general')->namespace('General')->group(function () {
                Route::prefix('class-type')->group(function () {
                    Route::get('/', 'ClassTypeController@index');
                    Route::get('datatable', 'ClassTypeController@datatable');
                    Route::post('create-data', 'ClassTypeController@createData');
                    Route::get('show-data', 'ClassTypeController@showData');
                    Route::post('update-data', 'ClassTypeController@updateData');
                    Route::delete('destroy-data', 'ClassTypeController@destroyData');
                });

                Route::prefix('doctor')->group(function () {
                    Route::get('/', 'DoctorController@index');
                    Route::get('datatable', 'DoctorController@datatable');
                    Route::post('create-data', 'DoctorController@createData');
                    Route::get('show-data', 'DoctorController@showData');
                    Route::post('update-data', 'DoctorController@updateData');
                    Route::delete('destroy-data', 'DoctorController@destroyData');
                });

                Route::prefix('employee')->group(function () {
                    Route::get('/', 'EmployeeController@index');
                    Route::get('datatable', 'EmployeeController@datatable');
                    Route::post('create-data', 'EmployeeController@createData');
                    Route::get('show-data', 'EmployeeController@showData');
                    Route::post('update-data', 'EmployeeController@updateData');
                    Route::delete('destroy-data', 'EmployeeController@destroyData');
                });

                Route::prefix('medical-service')->group(function () {
                    Route::get('/', 'MedicalServiceController@index');
                    Route::get('datatable', 'MedicalServiceController@datatable');
                    Route::post('create-data', 'MedicalServiceController@createData');
                    Route::get('show-data', 'MedicalServiceController@showData');
                    Route::post('update-data', 'MedicalServiceController@updateData');
                    Route::delete('destroy-data', 'MedicalServiceController@destroyData');
                });

                Route::prefix('patient-group')->group(function () {
                    Route::get('/', 'PatientGroupController@index');
                    Route::get('datatable', 'PatientGroupController@datatable');
                    Route::post('create-data', 'PatientGroupController@createData');
                    Route::get('show-data', 'PatientGroupController@showData');
                    Route::post('update-data', 'PatientGroupController@updateData');
                    Route::delete('destroy-data', 'PatientGroupController@destroyData');
                });

                Route::prefix('religion')->group(function () {
                    Route::get('/', 'ReligionController@index');
                    Route::get('datatable', 'ReligionController@datatable');
                    Route::post('create-data', 'ReligionController@createData');
                    Route::get('show-data', 'ReligionController@showData');
                    Route::post('update-data', 'ReligionController@updateData');
                    Route::delete('destroy-data', 'ReligionController@destroyData');
                });

                Route::prefix('unit')->group(function () {
                    Route::get('/', 'UnitController@index');
                    Route::get('datatable', 'UnitController@datatable');
                    Route::post('create-data', 'UnitController@createData');
                    Route::get('show-data', 'UnitController@showData');
                    Route::post('update-data', 'UnitController@updateData');
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
                    Route::post('update-data', 'PatientController@updateData');
                    Route::delete('destroy-data', 'PatientController@destroyData');
                    Route::get('print/{id}', 'PatientController@print');
                });

                Route::prefix('dtd')->group(function () {
                    Route::get('/', 'DTDController@index');
                    Route::get('datatable', 'DTDController@datatable');
                    Route::post('create-data', 'DTDController@createData');
                    Route::get('show-data', 'DTDController@showData');
                    Route::post('update-data', 'DTDController@updateData');
                    Route::delete('destroy-data', 'DTDController@destroyData');
                });

                Route::prefix('icd')->group(function () {
                    Route::get('/', 'ICDController@index');
                    Route::get('datatable', 'ICDController@datatable');
                    Route::post('create-data', 'ICDController@createData');
                    Route::get('show-data', 'ICDController@showData');
                    Route::post('update-data', 'ICDController@updateData');
                    Route::delete('destroy-data', 'ICDController@destroyData');
                });
            });

            Route::prefix('room')->namespace('Room')->group(function () {
                Route::prefix('data')->group(function () {
                    Route::get('/', 'DataController@index');
                    Route::get('datatable', 'DataController@datatable');
                    Route::post('create-data', 'DataController@createData');
                    Route::get('show-data', 'DataController@showData');
                    Route::post('update-data', 'DataController@updateData');
                    Route::delete('destroy-data', 'DataController@destroyData');
                });

                Route::prefix('room-class')->group(function () {
                    Route::get('/', 'RoomClassController@index');
                    Route::get('datatable', 'RoomClassController@datatable');
                    Route::post('create-data', 'RoomClassController@createData');
                    Route::get('show-data', 'RoomClassController@showData');
                    Route::post('update-data', 'RoomClassController@updateData');
                    Route::delete('destroy-data', 'RoomClassController@destroyData');
                });

                Route::prefix('room-space')->group(function () {
                    Route::get('/', 'RoomSpaceController@index');
                    Route::get('datatable', 'RoomSpaceController@datatable');
                    Route::post('create-data', 'RoomSpaceController@createData');
                    Route::get('show-data', 'RoomSpaceController@showData');
                    Route::post('update-data', 'RoomSpaceController@updateData');
                    Route::delete('destroy-data', 'RoomSpaceController@destroyData');
                });

                Route::prefix('bed')->group(function () {
                    Route::get('/', 'BedController@index');
                    Route::get('datatable', 'BedController@datatable');
                    Route::post('create-data', 'BedController@createData');
                    Route::get('show-data', 'BedController@showData');
                    Route::post('update-data', 'BedController@updateData');
                    Route::delete('destroy-data', 'BedController@destroyData');
                });
            });

            Route::prefix('action')->namespace('Action')->group(function () {
                Route::prefix('data')->group(function () {
                    Route::get('/', 'DataController@index');
                    Route::get('datatable', 'DataController@datatable');
                    Route::post('create-data', 'DataController@createData');
                    Route::get('show-data', 'DataController@showData');
                    Route::post('update-data', 'DataController@updateData');
                    Route::delete('destroy-data', 'DataController@destroyData');
                });

                Route::prefix('other')->group(function () {
                    Route::get('/', 'OtherController@index');
                    Route::get('datatable', 'OtherController@datatable');
                    Route::post('create-data', 'OtherController@createData');
                    Route::get('show-data', 'OtherController@showData');
                    Route::post('update-data', 'OtherController@updateData');
                    Route::delete('destroy-data', 'OtherController@destroyData');
                });

                Route::prefix('operative')->group(function () {
                    Route::get('/', 'OperativeController@index');
                    Route::get('datatable', 'OperativeController@datatable');
                    Route::post('create-data', 'OperativeController@createData');
                    Route::get('show-data', 'OperativeController@showData');
                    Route::post('update-data', 'OperativeController@updateData');
                    Route::delete('destroy-data', 'OperativeController@destroyData');
                });

                Route::prefix('non-operative')->group(function () {
                    Route::get('/', 'NonOperativeController@index');
                    Route::get('datatable', 'NonOperativeController@datatable');
                    Route::post('create-data', 'NonOperativeController@createData');
                    Route::get('show-data', 'NonOperativeController@showData');
                    Route::post('update-data', 'NonOperativeController@updateData');
                    Route::delete('destroy-data', 'NonOperativeController@destroyData');
                });

                Route::prefix('supporting')->group(function () {
                    Route::get('/', 'SupportingController@index');
                    Route::get('datatable', 'SupportingController@datatable');
                    Route::post('create-data', 'SupportingController@createData');
                    Route::get('show-data', 'SupportingController@showData');
                    Route::post('update-data', 'SupportingController@updateData');
                    Route::delete('destroy-data', 'SupportingController@destroyData');
                });

                Route::prefix('emergency-care')->group(function () {
                    Route::get('/', 'EmergencyCareController@index');
                    Route::get('datatable', 'EmergencyCareController@datatable');
                    Route::post('create-data', 'EmergencyCareController@createData');
                    Route::get('show-data', 'EmergencyCareController@showData');
                    Route::post('update-data', 'EmergencyCareController@updateData');
                    Route::delete('destroy-data', 'EmergencyCareController@destroyData');
                });
            });

            Route::prefix('operating-room')->namespace('OperatingRoom')->group(function () {
                Route::prefix('action')->group(function () {
                    Route::get('/', 'ActionController@index');
                    Route::get('datatable', 'ActionController@datatable');
                    Route::post('create-data', 'ActionController@createData');
                    Route::get('show-data', 'ActionController@showData');
                    Route::post('update-data', 'ActionController@updateData');
                    Route::delete('destroy-data', 'ActionController@destroyData');
                });

                Route::prefix('action-type')->group(function () {
                    Route::get('/', 'ActionTypeController@index');
                    Route::get('datatable', 'ActionTypeController@datatable');
                    Route::post('create-data', 'ActionTypeController@createData');
                    Route::get('show-data', 'ActionTypeController@showData');
                    Route::post('update-data', 'ActionTypeController@updateData');
                    Route::delete('destroy-data', 'ActionTypeController@destroyData');
                });

                Route::prefix('operating-group')->group(function () {
                    Route::get('/', 'OperatingGroupController@index');
                    Route::get('datatable', 'OperatingGroupController@datatable');
                    Route::post('create-data', 'OperatingGroupController@createData');
                    Route::get('show-data', 'OperatingGroupController@showData');
                    Route::post('update-data', 'OperatingGroupController@updateData');
                    Route::delete('destroy-data', 'OperatingGroupController@destroyData');
                });

                Route::prefix('anesthetist')->group(function () {
                    Route::get('/', 'AnesthetistController@index');
                    Route::get('datatable', 'AnesthetistController@datatable');
                    Route::post('create-data', 'AnesthetistController@createData');
                    Route::get('show-data', 'AnesthetistController@showData');
                    Route::post('update-data', 'AnesthetistController@updateData');
                    Route::delete('destroy-data', 'AnesthetistController@destroyData');
                });
            });

            Route::prefix('health-service')->namespace('HealthService')->group(function () {
                Route::prefix('functional-service')->group(function () {
                    Route::get('/', 'FunctionalServiceController@index');
                    Route::get('datatable', 'FunctionalServiceController@datatable');
                    Route::post('create-data', 'FunctionalServiceController@createData');
                    Route::get('show-data', 'FunctionalServiceController@showData');
                    Route::post('update-data', 'FunctionalServiceController@updateData');
                    Route::delete('destroy-data', 'FunctionalServiceController@destroyData');
                });

                Route::prefix('bed')->group(function () {
                    Route::get('/', 'BedController@index');
                    Route::get('datatable', 'BedController@datatable');
                    Route::post('create-data', 'BedController@createData');
                    Route::get('show-data', 'BedController@showData');
                    Route::post('update-data', 'BedController@updateData');
                    Route::delete('destroy-data', 'BedController@destroyData');
                });
            });

            Route::prefix('poly')->namespace('Poly')->group(function () {
                Route::prefix('data')->group(function () {
                    Route::get('/', 'DataController@index');
                    Route::get('datatable', 'DataController@datatable');
                    Route::post('create-data', 'DataController@createData');
                    Route::get('show-data', 'DataController@showData');
                    Route::post('update-data', 'DataController@updateData');
                    Route::delete('destroy-data', 'DataController@destroyData');
                });

                Route::prefix('action')->group(function () {
                    Route::get('/', 'ActionController@index');
                    Route::get('datatable', 'ActionController@datatable');
                    Route::post('create-data', 'ActionController@createData');
                    Route::get('show-data', 'ActionController@showData');
                    Route::post('update-data', 'ActionController@updateData');
                    Route::delete('destroy-data', 'ActionController@destroyData');
                });
            });

            Route::prefix('lab')->namespace('Lab')->group(function () {
                Route::prefix('category')->group(function () {
                    Route::get('/', 'CategoryController@index');
                    Route::get('datatable', 'CategoryController@datatable');
                    Route::post('create-data', 'CategoryController@createData');
                    Route::get('show-data', 'CategoryController@showData');
                    Route::post('update-data', 'CategoryController@updateData');
                    Route::delete('destroy-data', 'CategoryController@destroyData');
                });

                Route::prefix('item')->group(function () {
                    Route::get('/', 'ItemController@index');
                    Route::get('datatable', 'ItemController@datatable');
                    Route::post('create-data', 'ItemController@createData');
                    Route::get('show-data', 'ItemController@showData');
                    Route::post('update-data', 'ItemController@updateData');
                    Route::delete('destroy-data', 'ItemController@destroyData');
                });

                Route::prefix('item-parent')->group(function () {
                    Route::get('/', 'ItemParentController@index');
                    Route::get('datatable', 'ItemParentController@datatable');
                    Route::post('create-data', 'ItemParentController@createData');
                    Route::get('show-data', 'ItemParentController@showData');
                    Route::post('update-data', 'ItemParentController@updateData');
                    Route::delete('destroy-data', 'ItemParentController@destroyData');
                });

                Route::prefix('item-option')->group(function () {
                    Route::get('/', 'ItemOptionController@index');
                    Route::get('datatable', 'ItemOptionController@datatable');
                    Route::post('create-data', 'ItemOptionController@createData');
                    Route::get('show-data', 'ItemOptionController@showData');
                    Route::post('update-data', 'ItemOptionController@updateData');
                    Route::delete('destroy-data', 'ItemOptionController@destroyData');
                });

                Route::prefix('item-group')->group(function () {
                    Route::get('/', 'ItemGroupController@index');
                    Route::get('datatable', 'ItemGroupController@datatable');
                    Route::post('create-data', 'ItemGroupController@createData');
                    Route::get('show-data', 'ItemGroupController@showData');
                    Route::post('update-data', 'ItemGroupController@updateData');
                    Route::delete('destroy-data', 'ItemGroupController@destroyData');
                });

                Route::prefix('fee')->group(function () {
                    Route::get('/', 'FeeController@index');
                    Route::get('datatable', 'FeeController@datatable');
                    Route::post('create-data', 'FeeController@createData');
                    Route::get('show-data', 'FeeController@showData');
                    Route::post('update-data', 'FeeController@updateData');
                    Route::delete('destroy-data', 'FeeController@destroyData');
                });

                Route::prefix('condition')->group(function () {
                    Route::get('/', 'ConditionController@index');
                    Route::get('datatable', 'ConditionController@datatable');
                    Route::post('create-data', 'ConditionController@createData');
                    Route::get('show-data', 'ConditionController@showData');
                    Route::post('update-data', 'ConditionController@updateData');
                    Route::delete('destroy-data', 'ConditionController@destroyData');
                });
            });

            Route::prefix('radiology')->namespace('Radiology')->group(function () {
                Route::prefix('data')->group(function () {
                    Route::get('/', 'DataController@index');
                    Route::get('datatable', 'DataController@datatable');
                    Route::post('create-data', 'DataController@createData');
                    Route::get('show-data', 'DataController@showData');
                    Route::post('update-data', 'DataController@updateData');
                    Route::delete('destroy-data', 'DataController@destroyData');
                });

                Route::prefix('action')->group(function () {
                    Route::get('/', 'ActionController@index');
                    Route::get('datatable', 'ActionController@datatable');
                    Route::post('create-data', 'ActionController@createData');
                    Route::get('show-data', 'ActionController@showData');
                    Route::post('update-data', 'ActionController@updateData');
                    Route::delete('destroy-data', 'ActionController@destroyData');
                });
            });
        });

        Route::prefix('collection')->namespace('Collection')->group(function () {
            Route::prefix('outpatient')->group(function () {
                Route::get('/', 'OutpatientController@index');
                Route::get('datatable', 'OutpatientController@datatable');
                Route::get('load-patient', 'OutpatientController@loadPatient');
                Route::match(['get', 'post'], 'register-patient', 'OutpatientController@registerPatient');
                Route::match(['get', 'post'], 'action/{id}', 'OutpatientController@action');
                Route::match(['get', 'post'], 'action/print/{id}', 'OutpatientController@actionPrint');
                Route::match(['get', 'post'], 'soap/{id}', 'OutpatientController@soap');
                Route::match(['get', 'post'], 'diagnosis/{id}', 'OutpatientController@diagnosis');
                Route::match(['get', 'post'], 'lab/{id}', 'OutpatientController@lab');
                Route::get('lab/print/{id}', 'OutpatientController@labPrint');
                Route::match(['get', 'post'], 'radiology/{id}', 'OutpatientController@radiology');
                Route::get('radiology/print/{id}', 'OutpatientController@radiologyPrint');
                Route::match(['get', 'post'], 'operating-room/{id}', 'OutpatientController@operatingRoom');
                Route::match(['get', 'post'], 'update-data/{id}', 'OutpatientController@updateData');
                Route::delete('destroy-data', 'OutpatientController@destroyData');
                Route::get('print/{outpatient_id}', 'OutpatientController@print');
            });

            Route::prefix('inpatient')->group(function () {
                Route::get('/', 'InpatientController@index');
                Route::get('datatable', 'InpatientController@datatable');
                Route::get('load-patient', 'InpatientController@loadPatient');
                Route::match(['get', 'post'], 'register-patient', 'InpatientController@registerPatient');
                Route::match(['get', 'post'], 'action/{id}', 'InpatientController@action');
                Route::match(['get', 'post'], 'recipe/{id}', 'InpatientController@recipe');
                Route::match(['get', 'post'], 'diagnosis/{id}', 'InpatientController@diagnosis');
                Route::match(['get', 'post'], 'lab/{id}', 'InpatientController@lab');
                Route::get('lab/print/{id}', 'InpatientController@labPrint');
                Route::match(['get', 'post'], 'radiology/{id}', 'InpatientController@radiology');
                Route::get('radiology/print/{id}', 'InpatientController@radiologyPrint');
                Route::match(['get', 'post'], 'operating-room/{id}', 'InpatientController@operatingRoom');
                Route::get('print/{id}', 'InpatientController@print');
                Route::match(['get', 'post'], 'checkout/{id}', 'InpatientController@checkout');
                Route::match(['get', 'post'], 'update-data/{id}', 'InpatientController@updateData');
                Route::delete('destroy-data', 'InpatientController@destroyData');
            });

            Route::prefix('emergency-department')->group(function () {
                Route::get('/', 'EmergencyDepartmentController@index');
                Route::get('datatable', 'EmergencyDepartmentController@datatable');
                Route::get('load-patient', 'EmergencyDepartmentController@loadPatient');
                Route::match(['get', 'post'], 'register-patient', 'EmergencyDepartmentController@registerPatient');
                Route::match(['get', 'post'], 'action/{id}', 'EmergencyDepartmentController@action');
                Route::match(['get', 'post'], 'recipe/{id}', 'EmergencyDepartmentController@recipe');
                Route::match(['get', 'post'], 'diagnosis/{id}', 'EmergencyDepartmentController@diagnosis');
                Route::match(['get', 'post'], 'lab/{id}', 'EmergencyDepartmentController@lab');
                Route::get('lab/print/{id}', 'EmergencyDepartmentController@labPrint');
                Route::match(['get', 'post'], 'radiology/{id}', 'EmergencyDepartmentController@radiology');
                Route::get('radiology/print/{id}', 'EmergencyDepartmentController@radiologyPrint');
                Route::get('print/{id}', 'EmergencyDepartmentController@print');
                Route::match(['get', 'post'], 'checkout/{id}', 'EmergencyDepartmentController@checkout');
                Route::match(['get', 'post'], 'update-data/{id}', 'EmergencyDepartmentController@updateData');
                Route::delete('destroy-data', 'EmergencyDepartmentController@destroyData');
            });
        });

        Route::prefix('operation')->namespace('Operation')->group(function () {
            Route::prefix('data')->group(function () {
                Route::get('/', 'DataController@index');
                Route::get('datatable', 'DataController@datatable');
                Route::match(['get', 'post'], 'manage/{id}', 'DataController@manage');
                Route::get('print/{id}', 'DataController@print');
                Route::delete('destroy-data', 'DataController@destroyData');
            });

            Route::prefix('summary')->group(function () {
                Route::get('/', 'SummaryController@index');
            });
        });

        Route::prefix('lab')->group(function () {
            Route::get('/', 'LabController@index');
            Route::get('datatable', 'LabController@datatable');
            Route::match(['get', 'post'], 'process/{id}', 'LabController@process');
            Route::get('print/{id}', 'LabController@print');
        });

        Route::prefix('radiology')->group(function () {
            Route::get('/', 'RadiologyController@index');
            Route::get('datatable', 'RadiologyController@datatable');
            Route::match(['get', 'post'], 'process/{id}', 'RadiologyController@process');
            Route::get('print/{id}', 'RadiologyController@print');
        });

        Route::prefix('pharmacy')->namespace('Pharmacy')->group(function () {
            Route::prefix('distributor')->group(function () {
                Route::get('/', 'DistributorController@index');
                Route::get('datatable', 'DistributorController@datatable');
                Route::post('create-data', 'DistributorController@createData');
                Route::get('show-data', 'DistributorController@showData');
                Route::post('update-data', 'DistributorController@updateData');
                Route::delete('destroy-data', 'DistributorController@destroyData');
            });

            Route::prefix('factory')->group(function () {
                Route::get('/', 'FactoryController@index');
                Route::get('datatable', 'FactoryController@datatable');
                Route::post('create-data', 'FactoryController@createData');
                Route::get('show-data', 'FactoryController@showData');
                Route::post('update-data', 'FactoryController@updateData');
                Route::delete('destroy-data', 'FactoryController@destroyData');
            });

            Route::prefix('medicine')->group(function () {
                Route::get('/', 'MedicineController@index');
                Route::get('datatable', 'MedicineController@datatable');
                Route::post('create-data', 'MedicineController@createData');
                Route::get('show-data', 'MedicineController@showData');
                Route::post('update-data', 'MedicineController@updateData');
                Route::delete('destroy-data', 'MedicineController@destroyData');
            });

            Route::prefix('stock')->group(function () {
                Route::get('/', 'StockController@index');
                Route::get('datatable', 'StockController@datatable');
                Route::post('create-data', 'StockController@createData');
                Route::get('show-data', 'StockController@showData');
                Route::post('update-data', 'StockController@updateData');
                Route::delete('destroy-data', 'StockController@destroyData');
            });

            Route::prefix('request')->group(function () {
                Route::get('/', 'RequestController@index');
                Route::get('datatable', 'RequestController@datatable');
                Route::match(['get', 'post'], 'detail/{id}', 'RequestController@detail');
            });

            Route::prefix('mutation')->group(function () {
                Route::get('/', 'MutationController@index');
                Route::get('load-data', 'MutationController@loadData');
                Route::get('print', 'MutationController@print');
            });
        });

        Route::prefix('accounting')->namespace('Accounting')->group(function () {
            Route::prefix('chart-of-account')->group(function () {
                Route::get('/', 'ChartOfAccountController@index');
                Route::get('load-parent', 'ChartOfAccountController@loadParent');
                Route::get('datatable', 'ChartOfAccountController@datatable');
                Route::post('create-data', 'ChartOfAccountController@createData');
                Route::get('show-data', 'ChartOfAccountController@showData');
                Route::post('update-data', 'ChartOfAccountController@updateData');
                Route::delete('destroy-data', 'ChartOfAccountController@destroyData');
            });
        });

        Route::prefix('finance')->namespace('Finance')->group(function () {
            Route::prefix('budget')->group(function () {
                Route::get('/', 'BudgetController@index');
                Route::get('datatable', 'BudgetController@datatable');
                Route::get('detail/{id}', 'BudgetController@detail');
                Route::match(['get', 'post'], 'create', 'BudgetController@create');
                Route::match(['get', 'post'], 'update/{id}', 'BudgetController@update');
                Route::delete('destroy-data', 'BudgetController@destroyData');
            });

            Route::prefix('cash-bank')->group(function () {
                Route::get('/', 'CashBankController@index');
                Route::get('datatable', 'CashBankController@datatable');
                Route::post('create-data', 'CashBankController@createData');
                Route::get('show-data', 'CashBankController@showData');
                Route::post('update-data', 'CashBankController@updateData');
                Route::delete('destroy-data', 'CashBankController@destroyData');
            });
        });

        Route::prefix('report')->namespace('Report')->group(function () {
            Route::prefix('medicine')->group(function () {
                Route::get('/', 'MedicineController@index');
                Route::get('datatable', 'MedicineController@datatable');
            });

            Route::prefix('finance')->namespace('Finance')->group(function () {
                Route::prefix('budget')->group(function () {
                    Route::get('/', 'BudgetController@index');
                });
            });
        });

        Route::prefix('setting')->namespace('Setting')->group(function () {
            Route::prefix('role')->group(function () {
                Route::get('/', 'RoleController@index');
                Route::get('datatable', 'RoleController@datatable');
                Route::post('create-data', 'RoleController@createData');
                Route::get('show-data', 'RoleController@showData');
                Route::post('update-data', 'RoleController@updateData');
                Route::delete('destroy-data', 'RoleController@destroyData');
            });

            Route::prefix('user')->group(function () {
                Route::get('/', 'UserController@index');
                Route::get('datatable', 'UserController@datatable');
                Route::post('create-data', 'UserController@createData');
                Route::get('show-data', 'UserController@showData');
                Route::post('update-data', 'UserController@updateData');
                Route::delete('destroy-data', 'UserController@destroyData');
            });
        });
    });
});
