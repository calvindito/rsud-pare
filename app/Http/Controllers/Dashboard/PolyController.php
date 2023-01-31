<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Unit;
use App\Http\Controllers\Controller;

class PolyController extends Controller
{
    public function general()
    {
        $data = [
            'unit' => Unit::where('type', 2)->orderBy('name')->get(),
            'content' => 'dashboard.poly'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
