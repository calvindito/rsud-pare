<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inpatient extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inpatients';

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
    protected $appends = ['type_format_result', 'status_format_result', 'ending_format_result'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'observation' => 'object',
        'supervision_doctor' => 'object'
    ];

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
     * getStatusFormatResultAttribute
     *
     * @return void
     */
    protected function getStatusFormatResultAttribute()
    {
        $status = isset($this->attributes['status']) ? $this->attributes['status'] : null;

        if ($status == 1) {
            $text = 'Sedang Dirawat';
        } else if ($status == 2) {
            $text = 'Pindah Kamar';
        } else if ($status == 3) {
            $text = 'Pulang';
        } else if ($status == 4) {
            $text = 'Keluar Kamar';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }

    /**
     * getEndingFormatResultAttribute
     *
     * @return void
     */
    protected function getEndingFormatResultAttribute()
    {
        $ending = isset($this->attributes['ending']) ? $this->attributes['ending'] : null;

        if ($ending == 1) {
            $text = 'Sembuh';
        } else if ($ending == 2) {
            $text = 'Rujuk';
        } else if ($ending == 3) {
            $text = 'Pulang Paksa';
        } else if ($ending == 4) {
            $text = 'Meniggal < 48 Jam';
        } else if ($ending == 5) {
            $text = 'Meniggal > 48 Jam';
        } else if ($ending == 6) {
            $text = 'Tidak Diketahui';
        } else if ($ending == 7) {
            $text = 'Konsul ke Poli Lain';
        } else {
            $text = 'Belum Ada Hasil';
        }

        return $text;
    }

    /**
     * parent
     *
     * @return void
     */
    public function parent()
    {
        return $this->belongsTo(Inpatient::class, 'parent_id')->withTrashed();
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
     * roomType
     *
     * @return void
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class)->withTrashed();
    }

    /**
     * functionalService
     *
     * @return void
     */
    public function functionalService()
    {
        return $this->belongsTo(FunctionalService::class)->withTrashed();
    }

    /**
     * status
     *
     * @return void
     */
    public function status()
    {
        $status = $this->status;

        if ($status == 1) {
            $html = '<span class="badge bg-indigo">Sedang Dirawat</span>';
        } else if ($status == 2) {
            $html = '<span class="badge bg-primary">Pindah Kamar</span>';
        } else if ($status == 3) {
            $html = '<span class="badge bg-success">Pulang</span>';
        } else if ($status == 4) {
            $html = '<span class="badge bg-teal">Keluar Kamar</span>';
        } else {
            $html = '<span class="badge bg-warning">Invalid</span>';
        }

        return $html;
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
     * inpatientHealth
     *
     * @return void
     */
    public function inpatientHealth()
    {
        return $this->hasMany(InpatientHealth::class);
    }

    /**
     * inpatientNonOperative
     *
     * @return void
     */
    public function inpatientNonOperative()
    {
        return $this->hasMany(InpatientNonOperative::class);
    }

    /**
     * inpatientOperative
     *
     * @return void
     */
    public function inpatientOperative()
    {
        return $this->hasMany(InpatientOperative::class);
    }

    /**
     * inpatientOther
     *
     * @return void
     */
    public function inpatientOther()
    {
        return $this->hasMany(InpatientOther::class);
    }

    /**
     * inpatientPackage
     *
     * @return void
     */
    public function inpatientPackage()
    {
        return $this->hasMany(InpatientPackage::class);
    }

    /**
     * inpatientService
     *
     * @return void
     */
    public function inpatientService()
    {
        return $this->hasMany(InpatientService::class);
    }

    /**
     * inpatientSupporting
     *
     * @return void
     */
    public function inpatientSupporting()
    {
        return $this->hasMany(InpatientSupporting::class);
    }

    /**
     * recipe
     *
     * @return void
     */
    public function recipe()
    {
        return $this->morphMany(Recipe::class, 'recipeable');
    }

    /**
     * inpatientDiagnosis
     *
     * @return void
     */
    public function inpatientDiagnosis()
    {
        return $this->hasMany(InpatientDiagnosis::class);
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

    /**
     * operation
     *
     * @return void
     */
    public function operation()
    {
        return $this->morphOne(Operation::class, 'operationable')->withTrashed();
    }
}
