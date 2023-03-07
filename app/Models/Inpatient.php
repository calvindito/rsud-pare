<?php

namespace App\Models;

use App\Helpers\Simrs;
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
        $text = empty($type) ? 'Invalid' : Simrs::nursingType($type);

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
        return $this->belongsTo(Inpatient::class, 'parent_id');
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
     * bed
     *
     * @return void
     */
    public function bed()
    {
        return $this->belongsTo(Bed::class);
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
        return sprintf('%07s', $this->id);
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
     * dispensaryRequest
     *
     * @return void
     */
    public function dispensaryRequest()
    {
        return $this->morphMany(DispensaryRequest::class, 'dispensary_requestable');
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
        return $this->morphOne(Operation::class, 'operationable');
    }

    /**
     * total
     *
     * @return void
     */
    public function total()
    {
        $total = 0;
        $total += $this->observation->nominal ?? 0;
        $total += $this->supervision_doctor->nominal ?? 0;
        $total += !empty($this->fee_room) ? $this->fee_room : 0;
        $total += !empty($this->fee_nursing_care) ? $this->fee_nursing_care : 0;
        $total += !empty($this->fee_nutritional_care) ? $this->fee_nutritional_care * $this->fee_nutritional_care_qty ?? 0 : 0;
        $total += $this->inpatientHealth->sum('emergency_care');
        $total += $this->inpatientHealth->sum('hospitalization');
        $total += $this->inpatientNonOperative->sum('emergency_care');
        $total += $this->inpatientNonOperative->sum('hospitalization');
        $total += $this->inpatientOperative->sum('nominal');
        $total += $this->inpatientPackage->sum('nominal');
        $total += $this->inpatientSupporting->sum('emergency_care');
        $total += $this->inpatientSupporting->sum('hospitalization');
        $total += $this->radiologyRequest->sum('consumables');
        $total += $this->radiologyRequest->sum('hospital_service');
        $total += $this->radiologyRequest->sum('service');
        $total += $this->radiologyRequest->sum('fee');
        $total += $this->operation->hospital_service ?? 0;
        $total += $this->operation->doctor_operating_room ?? 0;
        $total += $this->operation->doctor_anesthetist ?? 0;
        $total += $this->operation->nurse_operating_room ?? 0;
        $total += $this->operation->nurse_anesthetist ?? 0;
        $total += $this->operation->material ?? 0;
        $total += $this->operation->monitoring ?? 0;
        $total += $this->operation->nursing_care ?? 0;

        foreach ($this->inpatientOther as $io) {
            $emergencyCare = !empty($io->emergency_care) ? $io->emergency_care : 0;
            $hospitalizationQty = !empty($io->hospitalization_qty) ? $io->hospitalization_qty : 0;
            $hospitalization = !empty($io->hospitalization) ? $io->hospitalization : 0;
            $total += $emergencyCare + ($hospitalization * $hospitalizationQty);
        }

        foreach ($this->inpatientService as $is) {
            $emergencyCareQty = $is->emergency_care->qty ?? 0;
            $emergencyCare = $is->emergency_care->nominal ?? 0;
            $hospitalizationQty = $is->hospitalization->qty ?? 0;
            $hospitalization = $is->hospitalization->nominal ?? 0;
            $total += ($emergencyCare * $emergencyCareQty) + ($hospitalization * $hospitalizationQty);
        }

        foreach ($this->dispensaryRequest as $dr) {
            $qty = $dr->qty;
            $price = $dr->price_sell;
            $discount = $dr->discount;

            if ($discount > 0) {
                $totalDiscount = ($discount / 100) * $price;
                $price -= $totalDiscount;
            }

            $total += $price * $qty;
        }

        foreach ($this->labRequest as $lr) {
            $consumables = $lr->labRequestDetail->sum('consumables');
            $hospitalService = $lr->labRequestDetail->sum('hospital_service');
            $service = $lr->labRequestDetail->sum('service');
            $total += $consumables + $hospitalService + $service;
        }

        return $total;
    }

    /**
     * costBreakdown
     *
     * @return void
     */
    public function costBreakdown()
    {
        $action = 0;
        $actionService = 0;
        $actionOperative = 0;
        $actionNonOperative = 0;
        $actionSupporting = 0;
        $actionHealth = 0;
        $actionOther = 0;
        $actionPackage = 0;
        $dispensaryRequest = 0;
        $lab = 0;
        $radiology = 0;
        $operation = 0;

        $actionService += $this->observation->nominal ?? 0;
        $actionService += $this->supervision_doctor->nominal ?? 0;
        $actionService += !empty($this->fee_room) ? $this->fee_room : 0;
        $actionService += !empty($this->fee_nursing_care) ? $this->fee_nursing_care : 0;
        $actionService += !empty($this->fee_nutritional_care) ? $this->fee_nutritional_care * $this->fee_nutritional_care_qty ?? 0 : 0;

        $actionHealth += $this->inpatientHealth->sum('emergency_care');
        $actionHealth += $this->inpatientHealth->sum('hospitalization');

        $actionNonOperative += $this->inpatientNonOperative->sum('emergency_care');
        $actionNonOperative += $this->inpatientNonOperative->sum('hospitalization');

        $actionOperative += $this->inpatientOperative->sum('nominal');

        $actionPackage += $this->inpatientPackage->sum('nominal');

        $actionSupporting += $this->inpatientSupporting->sum('emergency_care');
        $actionSupporting += $this->inpatientSupporting->sum('hospitalization');

        $radiology += $this->radiologyRequest->sum('consumables');
        $radiology += $this->radiologyRequest->sum('hospital_service');
        $radiology += $this->radiologyRequest->sum('service');
        $radiology += $this->radiologyRequest->sum('fee');

        $operation += $this->operation->hospital_service ?? 0;
        $operation += $this->operation->doctor_operating_room ?? 0;
        $operation += $this->operation->doctor_anesthetist ?? 0;
        $operation += $this->operation->nurse_operating_room ?? 0;
        $operation += $this->operation->nurse_anesthetist ?? 0;
        $operation += $this->operation->material ?? 0;
        $operation += $this->operation->monitoring ?? 0;
        $operation += $this->operation->nursing_care ?? 0;

        foreach ($this->inpatientOther as $io) {
            $emergencyCare = !empty($io->emergency_care) ? $io->emergency_care : 0;
            $hospitalizationQty = !empty($io->hospitalization_qty) ? $io->hospitalization_qty : 0;
            $hospitalization = !empty($io->hospitalization) ? $io->hospitalization : 0;
            $actionOther += $emergencyCare + ($hospitalization * $hospitalizationQty);
        }

        foreach ($this->inpatientService as $is) {
            $emergencyCareQty = $is->emergency_care->qty ?? 0;
            $emergencyCare = $is->emergency_care->nominal ?? 0;
            $hospitalizationQty = $is->hospitalization->qty ?? 0;
            $hospitalization = $is->hospitalization->nominal ?? 0;
            $actionService += ($emergencyCare * $emergencyCareQty) + ($hospitalization * $hospitalizationQty);
        }

        foreach ($this->dispensaryRequest as $dr) {
            $qty = $dr->qty;
            $price = $dr->price_sell;
            $discount = $dr->discount;

            if ($discount > 0) {
                $totalDiscount = ($discount / 100) * $price;
                $price -= $totalDiscount;
            }

            $dispensaryRequest += $price * $qty;
        }

        foreach ($this->labRequest as $lr) {
            $consumables = $lr->labRequestDetail->sum('consumables');
            $hospitalService = $lr->labRequestDetail->sum('hospital_service');
            $service = $lr->labRequestDetail->sum('service');
            $lab += $consumables + $hospitalService + $service;
        }

        $action += $actionService;
        $action += $actionOperative;
        $action += $actionNonOperative;
        $action += $actionSupporting;
        $action += $actionHealth;
        $action += $actionOther;
        $action += $actionPackage;

        $result = (object) [
            'action' => $action,
            'actionService' => $actionService,
            'actionOperative' => $actionOperative,
            'actionNonOperative' => $actionNonOperative,
            'actionSupporting' => $actionSupporting,
            'actionHealth' => $actionHealth,
            'actionOther' => $actionOther,
            'actionPackage' => $actionPackage,
            'dispensaryRequest' => $dispensaryRequest,
            'lab' => $lab,
            'radiology' => $radiology,
            'operation' => $operation
        ];

        return $result;
    }

    /**
     * dispensary
     *
     * @return void
     */
    public function dispensary()
    {
        return $this->belongsTo(Dispensary::class);
    }

    /**
     * inpatientSoap
     *
     * @return void
     */
    public function inpatientSoap()
    {
        return $this->hasMany(InpatientSoap::class);
    }

    /**
     * paid
     *
     * @return void
     */
    public function paid()
    {
        $paid = $this->paid;

        if ($paid == 1) {
            $html = '<span class="badge bg-success">Terbayar</span>';
        } else if ($paid == 0) {
            $html = '<span class="badge bg-danger">Belum Bayar</span>';
        } else {
            $html = '<span class="badge bg-warning">Invalid</span>';
        }

        return $html;
    }

    /**
     * totalAction
     *
     * @return float
     */
    public function totalAction()
    {
        $total = 0;
        $total += $this->observation->nominal ?? 0;
        $total += $this->supervision_doctor->nominal ?? 0;
        $total += !empty($this->fee_room) ? $this->fee_room : 0;
        $total += !empty($this->fee_nursing_care) ? $this->fee_nursing_care : 0;
        $total += !empty($this->fee_nutritional_care) ? $this->fee_nutritional_care * $this->fee_nutritional_care_qty ?? 0 : 0;
        $total += $this->inpatientHealth->sum('emergency_care');
        $total += $this->inpatientHealth->sum('hospitalization');
        $total += $this->inpatientNonOperative->sum('emergency_care');
        $total += $this->inpatientNonOperative->sum('hospitalization');
        $total += $this->inpatientOperative->sum('nominal');
        $total += $this->inpatientPackage->sum('nominal');
        $total += $this->inpatientSupporting->sum('emergency_care');
        $total += $this->inpatientSupporting->sum('hospitalization');

        foreach ($this->inpatientOther as $io) {
            $emergencyCare = !empty($io->emergency_care) ? $io->emergency_care : 0;
            $hospitalizationQty = !empty($io->hospitalization_qty) ? $io->hospitalization_qty : 0;
            $hospitalization = !empty($io->hospitalization) ? $io->hospitalization : 0;
            $total += $emergencyCare + ($hospitalization * $hospitalizationQty);
        }

        foreach ($this->inpatientService as $is) {
            $emergencyCareQty = $is->emergency_care->qty ?? 0;
            $emergencyCare = $is->emergency_care->nominal ?? 0;
            $hospitalizationQty = $is->hospitalization->qty ?? 0;
            $hospitalization = $is->hospitalization->nominal ?? 0;
            $total += ($emergencyCare * $emergencyCareQty) + ($hospitalization * $hospitalizationQty);
        }

        return $total;
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
     * user
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
