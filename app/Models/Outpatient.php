<?php

namespace App\Models;

use App\Helpers\Simrs;
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
        $text = empty($type) ? 'Invalid' : Simrs::nursingType($type);

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
        return $this->belongsTo(Patient::class);
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
     * operation
     *
     * @return void
     */
    public function operation()
    {
        return $this->morphOne(Operation::class, 'operationable');
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
        } else if ($status == 5) {
            $text = 'Rujuk ke Poli Lain';
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
        return sprintf('%07s', $this->id);
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
        return $this->belongsTo(User::class);
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
     * dispensary
     *
     * @return void
     */
    public function dispensary()
    {
        return $this->belongsTo(Dispensary::class);
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
        $outpatientAction = $this->outpatientAction;
        $total = 0;

        if ($outpatientAction->count() > 0) {
            foreach ($outpatientAction as $oa) {
                $total += $oa->consumables;
                $total += $oa->hospital_service;
                $total += $oa->service;
            }
        }

        return $total;
    }

    /**
     * parent
     *
     * @return void
     */
    public function parent()
    {
        return $this->belongsTo(Outpatient::class, 'parent_id');
    }

    /**
     * costBreakdown
     *
     * @return void
     */
    public function costBreakdown()
    {
        $action = $this->totalAction();
        $dispensaryRequest = 0;
        $lab = 0;
        $radiology = 0;
        $operation = 0;

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

        $result = (object) [
            'action' => $action,
            'dispensaryRequest' => $dispensaryRequest,
            'lab' => $lab,
            'radiology' => $radiology,
            'operation' => $operation
        ];

        return $result;
    }

    /**
     * total
     *
     * @return float
     */
    public function total()
    {
        $total = 0;
        $total += $this->totalAction();

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
}
