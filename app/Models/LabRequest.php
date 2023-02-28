<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabRequest extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lab_requests';

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
     * labRequestable
     *
     * @return void
     */
    public function labRequestable()
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
     * labRequestDetail
     *
     * @return void
     */
    public function labRequestDetail()
    {
        return $this->hasMany(LabRequestDetail::class);
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
     * ref
     *
     * @return void
     */
    public function ref()
    {
        $model = $this->lab_requestable_type;

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
     * total
     *
     * @return float
     */
    public function total()
    {
        $total = 0;
        $total += $this->labRequestDetail->sum('consumables');
        $total += $this->labRequestDetail->sum('hospital_service');
        $total += $this->labRequestDetail->sum('service');

        return $total;
    }
}
