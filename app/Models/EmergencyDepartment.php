<?php

namespace App\Models;

use App\Helpers\Simrs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmergencyDepartment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'emergency_departments';

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
     * patient
     *
     * @return void
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class)->withTrashed();
    }

    /**
     * doctor
     *
     * @return void
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class)->withTrashed();
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
            $html = '<span class="badge bg-success">Pulang</span>';
        } else if ($status == 3) {
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
     * emergencyDepartmentHealth
     *
     * @return void
     */
    public function emergencyDepartmentHealth()
    {
        return $this->hasMany(EmergencyDepartmentHealth::class);
    }

    /**
     * emergencyDepartmentNonOperative
     *
     * @return void
     */
    public function emergencyDepartmentNonOperative()
    {
        return $this->hasMany(EmergencyDepartmentNonOperative::class);
    }

    /**
     * emergencyDepartmentOperative
     *
     * @return void
     */
    public function emergencyDepartmentOperative()
    {
        return $this->hasMany(EmergencyDepartmentOperative::class);
    }

    /**
     * emergencyDepartmentOther
     *
     * @return void
     */
    public function emergencyDepartmentOther()
    {
        return $this->hasMany(EmergencyDepartmentOther::class);
    }

    /**
     * emergencyDepartmentPackage
     *
     * @return void
     */
    public function emergencyDepartmentPackage()
    {
        return $this->hasMany(EmergencyDepartmentPackage::class);
    }

    /**
     * emergencyDepartmentService
     *
     * @return void
     */
    public function emergencyDepartmentService()
    {
        return $this->hasMany(EmergencyDepartmentService::class);
    }

    /**
     * emergencyDepartmentSupporting
     *
     * @return void
     */
    public function emergencyDepartmentSupporting()
    {
        return $this->hasMany(EmergencyDepartmentSupporting::class);
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
     * emergencyDepartmentDiagnosis
     *
     * @return void
     */
    public function emergencyDepartmentDiagnosis()
    {
        return $this->hasMany(EmergencyDepartmentDiagnosis::class);
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
     * total
     *
     * @return void
     */
    public function total()
    {
        $total = 0;
        $total += $this->observation->nominal ?? 0;
        $total += $this->supervision_doctor->nominal ?? 0;
        $total += $this->emergencyDepartmentHealth->sum('nominal');
        $total += $this->emergencyDepartmentNonOperative->sum('nominal');
        $total += $this->emergencyDepartmentPackage->sum('nominal');
        $total += $this->emergencyDepartmentSupporting->sum('nominal');
        $total += $this->emergencyDepartmentOther->sum('nominal');
        $total += $this->radiologyRequest->sum('consumables');
        $total += $this->radiologyRequest->sum('hospital_service');
        $total += $this->radiologyRequest->sum('service');
        $total += $this->radiologyRequest->sum('fee');

        foreach ($this->emergencyDepartmentService as $is) {
            $qty = $is->qty ?? 0;
            $nominal = $is->nominal ?? 0;
            $total += $nominal * $qty;
        }

        foreach ($this->recipe as $r) {
            $qty = $r->qty;
            $price = $r->price_sell;
            $discount = $r->discount;

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
        $actionService = 0;
        $actionNonOperative = 0;
        $actionSupporting = 0;
        $actionHealth = 0;
        $actionOther = 0;
        $actionPackage = 0;
        $recipe = 0;
        $lab = 0;
        $radiology = 0;

        $actionService += $this->observation->nominal ?? 0;
        $actionService += $this->supervision_doctor->nominal ?? 0;
        $actionHealth += $this->emergencyDepartmentHealth->sum('nominal');
        $actionNonOperative += $this->emergencyDepartmentNonOperative->sum('nominal');
        $actionPackage += $this->emergencyDepartmentPackage->sum('nominal');
        $actionSupporting += $this->emergencyDepartmentSupporting->sum('nominal');
        $actionOther += $this->emergencyDepartmentOther->sum('nominal');
        $radiology += $this->radiologyRequest->sum('consumables');
        $radiology += $this->radiologyRequest->sum('hospital_service');
        $radiology += $this->radiologyRequest->sum('service');
        $radiology += $this->radiologyRequest->sum('fee');

        foreach ($this->emergencyDepartmentService as $is) {
            $qty = $is->qty ?? 0;
            $nominal = $is->nominal ?? 0;
            $actionService += $nominal * $qty;
        }

        foreach ($this->recipe as $r) {
            $qty = $r->qty;
            $price = $r->price_sell;
            $discount = $r->discount;

            if ($discount > 0) {
                $totalDiscount = ($discount / 100) * $price;
                $price -= $totalDiscount;
            }

            $recipe += $price * $qty;
        }

        foreach ($this->labRequest as $lr) {
            $consumables = $lr->labRequestDetail->sum('consumables');
            $hospitalService = $lr->labRequestDetail->sum('hospital_service');
            $service = $lr->labRequestDetail->sum('service');
            $lab += $consumables + $hospitalService + $service;
        }

        $result = (object) [
            'actionService' => $actionService,
            'actionNonOperative' => $actionNonOperative,
            'actionSupporting' => $actionSupporting,
            'actionHealth' => $actionHealth,
            'actionOther' => $actionOther,
            'actionPackage' => $actionPackage,
            'recipe' => $recipe,
            'lab' => $lab,
            'radiology' => $radiology
        ];

        return $result;
    }
}
