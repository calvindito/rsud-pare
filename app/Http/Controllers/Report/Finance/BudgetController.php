<?php

namespace App\Http\Controllers\Report\Finance;

use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use App\Http\Controllers\Controller;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'budget' => ChartOfAccount::has('budget')->where('status', true)->orderBy('code')->get(),
            'year' => $request->year,
            'content' => 'report.finance.budget'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
