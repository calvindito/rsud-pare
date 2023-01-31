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

    public static function currentLongLine($unitId)
    {
        $now = date('Y-m-d');
        $unit = Unit::withCount([
            'outpatientPoly as total_long_line' => function ($query) use ($now) {
                $query->whereIn('status', [1, 3])
                    ->whereHas('outpatient', function ($query) use ($now) {
                        $query->whereDate('date_of_entry', $now);
                    });
            },
            'outpatientPoly as total_long_line_done' => function ($query) use ($now) {
                $query->whereIn('status', [2, 4])
                    ->whereHas('outpatient', function ($query) use ($now) {
                        $query->whereDate('date_of_entry', $now);
                    });
            }
        ])->find($unitId);

        $totalLongLine = $unit->total_long_line;
        $totalLongLineDone = $unit->total_long_line_done;
        $patient = null;

        $patient = Patient::whereHas('outpatient', function ($query) use ($now, $unitId) {
            $query->whereDate('date_of_entry', $now)
                ->whereHas('outpatientPoly', function ($query) use ($unitId) {
                    $query->where('unit_id', $unitId);
                });
        })->first();

        return (object)[
            'patient' => $patient,
            'active' => $totalLongLine == 0 ? $totalLongLineDone : abs($totalLongLine - $totalLongLineDone)
        ];
    }
}
