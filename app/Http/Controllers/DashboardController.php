<?php

namespace App\Http\Controllers;

class DashboardController extends Controller {

    public function general()
    {
        $data = [
            'title' => 'Dashboard Umum',
            'content' => 'dashboard.general'
        ];

        return view('layouts.index', ['data' => $data]);
    }

}
