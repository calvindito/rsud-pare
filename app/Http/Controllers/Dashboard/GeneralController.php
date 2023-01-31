<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeneralController extends Controller
{
    public function general()
    {
        $data = [
            'content' => 'dashboard.general'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
