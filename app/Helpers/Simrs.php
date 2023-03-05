<?php

namespace App\Helpers;

use App\Models\City;
use App\Models\District;
use App\Models\Province;
use App\Models\Outpatient;
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
        $strLength = strlen($menu);

        $roleAccess = RoleAccess::where('role_id', $role->id)->whereRaw("LEFT(menu, $strLength) = '$menu'")->count();

        if ($roleAccess > 0) {
            return true;
        }

        return false;
    }

    public static function formatRupiah($number)
    {
        return 'Rp ' . number_format($number, 0, '.', '.');
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

    private static function numeratorSay($value)
    {
        $score = abs($value);
        $word = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        $text = '';

        if ($score < 12) {
            $text = ' ' . $word[$score];
        } else if ($score < 20) {
            $text = static::numeratorSay($score - 10) . ' Belas';
        } else if ($score < 100) {
            $text = static::numeratorSay($score / 10) . ' Puluh' . static::numeratorSay($score % 10);
        } else if ($score < 200) {
            $text = ' Seratus' . static::numeratorSay($score - 100);
        } else if ($score < 1000) {
            $text = static::numeratorSay($score / 100) . ' Ratus' . static::numeratorSay($score % 100);
        } else if ($score < 2000) {
            $text = ' Seribu' . static::numeratorSay($score - 1000);
        } else if ($score < 1000000) {
            $text = static::numeratorSay($score / 1000) . ' Ribu' . static::numeratorSay($score % 1000);
        } else if ($score < 1000000000) {
            $text = static::numeratorSay($score / 1000000) . ' Juta' . static::numeratorSay($score % 1000000);
        } else if ($score < 1000000000000) {
            $text = static::numeratorSay($score / 1000000000) . ' Milyar' . static::numeratorSay(fmod($score, 1000000000));
        } else if ($score < 1000000000000000) {
            $text = static::numeratorSay($score / 1000000000000) . ' Trilyun' . static::numeratorSay(fmod($score, 1000000000000));
        }

        return $text;
    }

    public static function numerator($score)
    {
        if ($score < 0) {
            $result = 'Minus ' . trim(self::numeratorSay($score));
        } else {
            $result = trim(self::numeratorSay($score));
        }

        return $result . ' Rupiah';
    }

    public static function nursingType($index = null)
    {
        $type = ['Umum', 'Jamkesda', 'BPJS Tenaga Kerja', 'In Health', 'JR Jamkesda', 'JR BPJS', 'BPJS Kesehatan'];
        $result = $type;

        if ($index) {
            $result = isset($type[$index - 1]) ? $type[$index - 1] : 'Invalid';
        }

        return $result;
    }
}
