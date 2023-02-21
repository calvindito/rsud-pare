<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recipes';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

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
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * recipeable
     *
     * @return void
     */
    public function recipeable()
    {
        return $this->morphTo();
    }

    /**
     * itemStock
     *
     * @return void
     */
    public function itemStock()
    {
        return $this->belongsTo(ItemStock::class)->withTrashed();
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
     * user
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * statusable
     *
     * @return void
     */
    public function statusable($html = false)
    {
        $type = $this->recipeable_type;
        $id = $this->recipeable_id;
        $falseable = Recipe::where('recipeable_type', $type)->where('recipeable_id', $id)->whereNull('status')->count();

        if ($falseable > 0) {
            $result = $html ? '<span class="badge bg-primary">Menunggu Konfirmasi</span>' : false;
        } else {
            $result = $html ? '<span class="badge bg-success">Sudah Dikonfirmasi</span>' : true;
        }

        return $result;
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
            $text = 'Stok Tidak Cukup';
        } else if ($status == 2) {
            $text = 'Stok Kosong';
        } else if ($status == 3) {
            $text = 'Permintaan Ditolak';
        } else if ($status == 4) {
            $text = 'Disetujui';
        } else {
            $text = 'Belum Dikonfirmasi';
        }

        return $text;
    }

    /**
     * ref
     *
     * @return void
     */
    public function ref()
    {
        $model = $this->recipeable_type;

        if ($model == 'App\Models\Inpatient') {
            $text = 'Rawat Inap';
        } else if ($model == 'App\Models\EmergencyDepartment') {
            $text = 'IGD';
        } else {
            $text = 'Tidak Ada';
        }

        return $text;
    }
}
