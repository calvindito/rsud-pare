<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Operation extends Model
{
    use HasFactory, SoftDeletes;

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
            $text = 'Belum Operasi';
        } else if ($status == 2) {
            $text = 'Sedang Operasi';
        } else if ($status == 3) {
            $text = 'Selesai Operasi';
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
        return sprintf('%07s', $this->id);
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
            $html = '<span class="badge bg-danger col-12">Belum Operasi</span>';
        } else if ($status == 2) {
            $html = '<span class="badge bg-primary col-12">Sedang Operasi</span>';
        } else if ($status == 3) {
            $html = '<span class="badge bg-success col-12">Selesai Operasi</span>';
        } else {
            $html = '<span class="badge bg-warning col-12">Invalid</span>';
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
        $model = $this->operationable_type;

        if ($model == 'App\Models\Inpatient') {
            $text = 'Rawat Inap';
        } else if ($model == 'App\Models\Outpatient') {
            $text = 'Rawat Jalan';
        } else if ($model == 'App\Models\EmergencyDepartment') {
            $text = 'IGD';
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

    /**
     * operatingRoomAction
     *
     * @return void
     */
    public function operatingRoomAction()
    {
        return $this->belongsTo(OperatingRoomAction::class);
    }

    /**
     * operatingRoomAnesthetist
     *
     * @return void
     */
    public function operatingRoomAnesthetist()
    {
        return $this->belongsTo(OperatingRoomAnesthetist::class);
    }

    /**
     * doctorOperation
     *
     * @return void
     */
    public function doctorOperation()
    {
        return $this->belongsTo(Doctor::class, 'doctor_operation_id');
    }

    /**
     * total
     *
     * @return void
     */
    public function total()
    {
        $total = 0;
        $total += $this->hospital_service;
        $total += $this->doctor_operating_room;
        $total += $this->doctor_anesthetist;
        $total += $this->nurse_operating_room;
        $total += $this->nurse_anesthetist;
        $total += $this->monitoring;
        $total += $this->nursing_care;
        $total += $this->totalMaterial();

        return $total;
    }

    /**
     * totalMaterial
     *
     * @return float
     */
    public function totalMaterial()
    {
        $total = 0;

        if ($this->operationMaterial) {
            foreach ($this->operationMaterial as $op) {
                $discount = $op->discount;
                $qty = $op->qty;
                $price = $op->price_sell;
                $nett = $price * $qty;

                if ($discount > 0) {
                    $priceDiscount = ($discount / 100) * $price;
                    $nett = ($price - $priceDiscount) * $qty;
                }

                $total += $nett;
            }
        }

        return $total;
    }

    /**
     * operationMaterial
     *
     * @return void
     */
    public function operationMaterial()
    {
        return $this->hasMany(OperationMaterial::class);
    }
}
