<?php

namespace App\Http\Controllers\Setting;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use App\Http\Controllers\Controller;

class ChartOfAccountController extends Controller
{
    public function index()
    {
        $data = [
            'chartOfAccount' => ChartOfAccount::where('status', true)->orderBy('code')->get(),
            'content' => 'setting.chart-of-account'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function update(Request $request)
    {
        try {
            if ($request->has('slug')) {
                foreach ($request->slug as $key => $s) {
                    Setting::updateOrCreate([
                        'slug' => $s
                    ], [
                        'settingable_type' => ChartOfAccount::class,
                        'settingable_id' => isset($request->settingable_id[$key]) ? $request->settingable_id[$key] : null
                    ]);
                }
            }

            $response = [
                'code' => 200,
                'message' => 'Pengaturan bagan akun telah disimpan'
            ];
        } catch (\Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }
}
