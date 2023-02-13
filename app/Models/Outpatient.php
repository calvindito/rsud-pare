<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Outpatient extends Model
{
    use HasFactory, SoftDeletes;

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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['type_format_result', 'presence_format_result'];

    /**
     * getTypeAttribute
     *
     * @return void
     */
    protected function getTypeFormatResultAttribute()
    {
        $type = isset($this->attributes['type']) ? $this->attributes['type'] : null;

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
        } else if ($type == 8) {
            $text = 'BPJS Kesehatan';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }

    /**
     * getPresenceAttribute
     *
     * @return void
     */
    protected function getPresenceFormatResultAttribute()
    {
        $presence = isset($this->attributes['presence']) ? $this->attributes['presence'] : null;

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
     * patient
     *
     * @return void
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class)->withTrashed();
    }

    /**
     * unit
     *
     * @return void
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class)->withTrashed();
    }

    /**
     * operation
     *
     * @return void
     */
    public function operation()
    {
        return $this->morphOne(Operation::class, 'operationable')->withTrashed();
    }

    public function status()
    {
        $status = $this->status;

        if ($status == 1) {
            $text = 'Dalam Antrian';
        } else if ($status == 2) {
            $text = 'Pasien Tidak Ada';
        } else if ($status == 3) {
            $text = 'Sedang Ditangani';
        } else if ($status == 4) {
            $text = 'Selesai / Pulang';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }

    /**
     * code
     *
     * @return void
     */
    public function code()
    {
        return sprintf('%06s', $this->id);
    }

    /**
     * outpatientAction
     *
     * @return void
     */
    public function outpatientAction()
    {
        return $this->hasMany(OutpatientAction::class);
    }

    /**
     * user
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * outpatientSoap
     *
     * @return void
     */
    public function outpatientSoap()
    {
        return $this->hasMany(OutpatientSoap::class);
    }

    /**
     * outpatientDiagnosis
     *
     * @return void
     */
    public function outpatientDiagnosis()
    {
        return $this->hasMany(OutpatientDiagnosis::class);
    }

    /**
     * labRequest
     *
     * @return void
     */
    public function labRequest()
    {
        return $this->morphMany(LabRequest::class, 'lab_requestable');
    }

    /**
     * radiologyRequest
     *
     * @return void
     */
    public function radiologyRequest()
    {
        return $this->morphMany(RadiologyRequest::class, 'radiology_requestable');
    }
}
