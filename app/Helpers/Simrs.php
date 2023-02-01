<?php

namespace App\Helpers;

use App\Models\City;
use App\Models\Unit;
use App\Models\Patient;
use App\Models\District;
use App\Models\Province;
use App\Models\RoleAccess;

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
}
