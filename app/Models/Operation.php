<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Operation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operations';

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
    protected $appends = ['status_format_result'];

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
     * operationable
     *
     * @return void
     */
    public function operationable()
    {
        return $this->morphTo();
    }

    /**
     * patient
     *
     * @return void
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * operationDoctorAssistant
     *
     * @return void
     */
    public function operationDoctorAssistant()
    {
        return $this->hasMany(OperationDoctorAssistant::class);
    }

    /**
     * unit
     *
     * @return void
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * functionalService
     *
     * @return void
     */
    public function functionalService()
    {
        return $this->belongsTo(FunctionalService::class);
    }

    /**
     * doctor
     *
     * @return void
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
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
     * status
     *
     * @return void
     */
    public function status()
    {
        $status = $this->status;

        if ($status == 1) {
            $html = '<span class="badge bg-danger">Belum Operasi</span>';
        } else if ($status == 2) {
            $html = '<span class="badge bg-primary">Sedang Operasi</span>';
        } else if ($status == 3) {
            $html = '<span class="badge bg-success">Selesai Operasi</span>';
        } else {
            $html = '<span class="badge bg-warning">Invalid</span>';
        }

        return $html;
    }

    /**
     * ref
     *
     * @return void
     */
    public function ref()
    {
        $model = $this->lab_requestable_type;

        if ($model == 'App\Models\Inpatient') {
            $text = 'Rawat Inap';
        } else if ($model == 'App\Models\Outpatient') {
            $text = 'Rawat Jalan';
        } else {
            $text = 'Tidak Ada';
        }

        return $text;
    }

    /**
     * user
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
