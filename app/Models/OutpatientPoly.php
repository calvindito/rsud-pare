<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OutpatientPoly extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'outpatient_polies';

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
     * outpatient
     *
     * @return void
     */
    public function outpatient()
    {
        return $this->belongsTo(Outpatient::class);
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
}
