<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('dashboard/general');
});

Route::prefix('dashboard')->group(function() {
    Route::get('general', 'DashboardController@general');
});
