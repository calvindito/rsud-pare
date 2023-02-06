<?php

namespace App\Helpers;

use App\Models\City;
use App\Models\Unit;
use App\Models\Patient;
use App\Models\District;
use App\Models\Province;
use App\Models\RoleAccess;
use App\Models\OutpatientPoly;

class Simrs
{
    public static function locationById($id)
    {
        $province = Province::find($id);
        $city = City::find($id);
        $district = District::find($id);

        if ($province) {
            $data = $province;
        } else if ($city) {
            $data = $city;
        } else if ($district) {
            $data = $district;
        } else {
            $data = null;
        }

        return $data;
    }

    public static function hasPermission($menu)
    {
        $user = auth()->user();
        $role = $user->role;
        $roleAccess = RoleAccess::where('role_id', $role->id)->whereRaw("LOCATE('$menu', menu)")->count();

        if ($roleAccess > 0) {
            return true;
        }

        return false;
    }

    public static function formatRupiah($number)
    {
        return 'Rp ' . number_format($number, 2, ',', '.');
    }

    public static function todayLongLinePoly($unitId)
    {
        $data = OutpatientPoly::where('unit_id', $unitId)
            ->whereHas('outpatient', function ($query) {
                $query->whereDate('date_of_entry', date('Y-m-d'));
            })
            ->get();

        return (object)[
            'total' => $data->count(),
            'data' => $data
        ];
    }

    public static function tool($id = null)
    {
        $collect = ['Obat-Obatan', 'Infus', 'Alkes & BHP', 'Bank Darah', 'O2'];
        $data = $collect;

        if ($id) {
            $data = $collect[$id - 1];
        }

        return $data;
    }

    public static function numberable($value)
    {
        $number = 0;

        if (is_numeric($value)) {
            $number += $value;
        }

        return $number;
    }
}
