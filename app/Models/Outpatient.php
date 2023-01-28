<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Outpatient extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'outpatients';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * getTypeAttribute
     *
     * @return void
     */
    protected function getTypeAttribute()
    {
        $type = $this->attributes['type'];

        if ($type == 1) {
            $text = 'Umum';
        } else if ($type == 2) {
            $text = 'Jamkesda';
        } else if ($type == 3) {
            $text = 'BPJS Tenaga Kerja';
        } else if ($type == 4) {
            $text = 'In Health';
        } else if ($type == 5) {
            $text = 'JR Jamkesda';
        } else if ($type == 6) {
            $text = 'JR BPJS';
        } else if ($type == 7) {
            $text = 'JR Umum';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }

    protected function getPresenceAttribute()
    {
        $presence = $this->attributes['presence'];

        if ($presence == 1) {
            $text = 'Datang Sendiri';
        } else if ($presence == 2) {
            $text = 'Rujukan Dari Puskesmas';
        } else if ($presence == 3) {
            $text = 'Rujukan Dokter';
        } else if ($presence == 4) {
            $text = 'Rujukan Dari Rumah Sakit Lain';
        } else if ($presence == 5) {
            $text = 'Lahir Didalam Rumah Sakit';
        } else if ($presence == 6) {
            $text = 'Rujukan Dari Bidan';
        } else if ($presence == 7) {
            $text = 'Rujukan Klinik';
        } else if ($presence == 8) {
            $text = 'Rujukan Balai Pengobatan';
        } else if ($presence == 9) {
            $text = 'Diantar Polisi';
        } else if ($presence == 10) {
            $text = 'Diantar Ambulans';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }

    /**
     * outpatientPoly
     *
     * @return void
     */
    public function outpatientPoly()
    {
        return $this->hasMany(OutpatientPoly::class);
    }
}
