<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OutpatientAction extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'outpatient_actions';

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
     * doctor
     *
     * @return void
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * unitAction
     *
     * @return void
     */
    public function unitAction()
    {
        return $this->belongsTo(UnitAction::class);
    }

    /**
     * total
     *
     * @return void
     */
    public function total()
    {
        $consumables = $this->consumables;
        $hospitalService = $this->hospital_service;
        $service = $this->service;
        $total = $consumables + $hospitalService + $service;

        return $total;
    }

    /**
     * status
     *
     * @return void
     */
    public function status()
    {
        $status = $this->status;

        if ($status == true) {
            $html = '<span class="badge bg-success">Sudah Terbayar</span>';
        } else if ($status == false) {
            $html = '<span class="badge bg-danger">Belum Dibayar</span>';
        } else {
            $html = '<span class="badge bg-warning">Invalid</span>';
        }

        return $html;
    }

    /**
     * outpatient
     *
     * @return void
     */
    public function outpatient()
    {
        return $this->belongsTo(Outpatient::class);
    }
}
