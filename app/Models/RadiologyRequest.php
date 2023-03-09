<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RadiologyRequest extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'radiology_requests';

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
    protected $appends = ['critical_format_result'];

    /**
     * getGenderAttribute
     *
     * @return void
     */
    protected function getCriticalFormatResultAttribute()
    {
        $critical = isset($this->attributes['critical']) ? $this->attributes['critical'] : null;

        if ($critical == 1) {
            $text = 'Ya';
        } else if ($critical == 0) {
            $text = 'Tidak';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }

    /**
     * image
     *
     * @return void
     */
    public function image()
    {
        $image = asset('assets/no-image.png');

        if (Storage::exists($this->image)) {
            $image = asset(Storage::url($this->image));
        }

        return $image;
    }

    /**
     * radiologyRequestable
     *
     * @return void
     */
    public function radiologyRequestable()
    {
        return $this->morphTo();
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
     * patient
     *
     * @return void
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
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
     * radiology
     *
     * @return void
     */
    public function radiology()
    {
        return $this->belongsTo(Radiology::class);
    }

    /**
     * ref
     *
     * @return void
     */
    public function ref()
    {
        $model = $this->radiology_requestable_type;

        if ($model == 'App\Models\Inpatient') {
            $text = 'Rawat Inap';
        } else if ($model == 'App\Models\EmergencyDepartment') {
            $text = 'IGD';
        } else if ($model == 'App\Models\Outpatient') {
            $text = 'Rawat Jalan';
        } else {
            $text = 'Tidak Ada';
        }

        return $text;
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
            $html = '<span class="badge bg-secondary">Menunggu Diproses</span>';
        } else if ($status == 2) {
            $html = '<span class="badge bg-primary">Sedang Diproses</span>';
        } else if ($status == 3) {
            $html = '<span class="badge bg-success">Selesai</span>';
        } else if ($status == 4) {
            $html = '<span class="badge bg-danger">Ditolak</span>';
        } else {
            $html = '<span class="badge bg-warning">Invalid</span>';
        }

        return $html;
    }

    /**
     * total
     *
     * @return float
     */
    public function total()
    {
        $consumables = $this->consumables;
        $hospitalService = $this->hospital_service;
        $service = $this->service;
        $fee = $this->fee;
        $total = $consumables + $hospitalService + $service + $fee;

        return $total;
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
}
