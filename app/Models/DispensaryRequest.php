<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DispensaryRequest extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dispensary_requests';

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
     * dispensaryRequestable
     *
     * @return void
     */
    public function dispensaryRequestable()
    {
        return $this->morphTo();
    }

    /**
     * dispensaryItemStock
     *
     * @return void
     */
    public function dispensaryItemStock()
    {
        return $this->belongsTo(DispensaryItemStock::class);
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
        $type = $this->dispensary_requestable_type;
        $id = $this->dispensary_requestable_id;
        $falseable = DispensaryRequest::where('dispensary_requestable_type', $type)->where('dispensary_requestable_id', $id)->whereNull('status')->count();

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
        $model = $this->dispensary_requestable_type;

        if ($model == 'App\Models\Outpatient') {
            $text = 'Rawat Jalan';
        } else if ($model == 'App\Models\Inpatient') {
            $text = 'Rawat Inap';
        } else if ($model == 'App\Models\EmergencyDepartment') {
            $text = 'IGD';
        } else {
            $text = 'Tidak Ada';
        }

        return $text;
    }
}
