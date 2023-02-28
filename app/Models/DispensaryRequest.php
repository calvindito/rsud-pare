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
        return $this->belongsTo(Patient::class);
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
     * statusable
     *
     * @return void
     */
    public function statusable($html = false)
    {
        $type = $this->dispensary_requestable_type;
        $id = $this->dispensary_requestable_id;
        $dispensaryId = $this->dispensary_id;

        $falseable = DispensaryRequest::where('dispensary_requestable_type', $type)
            ->where('dispensary_requestable_id', $id)
            ->where('dispensary_id', $dispensaryId)
            ->whereNull('status')
            ->count();

        $trueable = DispensaryRequest::where('dispensary_requestable_type', $type)
            ->where('dispensary_requestable_id', $id)
            ->where('dispensary_id', $dispensaryId)
            ->whereNotNull('status')
            ->count();

        if ($falseable > 0) {
            $result = $html ? '<span class="badge bg-primary">' . $falseable . ' Item Menunggu Konfirmasi</span>' : false;
        } else {
            $result = $html ? '<span class="badge bg-success">' . $trueable . ' Item Sudah Dikonfirmasi</span>' : true;
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
     * dispensaryRequestItem
     *
     * @return void
     */
    public function dispensaryRequestItem()
    {
        $data = DispensaryRequest::with('dispensaryItemStock')
            ->where('dispensary_requestable_type', $this->dispensary_requestable_type)
            ->where('dispensary_requestable_id', $this->dispensary_requestable_id)
            ->where('dispensary_id', $this->dispensary_id)
            ->get();

        return $data;
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

        $data = DispensaryRequest::with('dispensaryItemStock')
            ->where('dispensary_requestable_type', $this->dispensary_requestable_type)
            ->where('dispensary_requestable_id', $this->dispensary_requestable_id)
            ->where('dispensary_id', $this->dispensary_id)
            ->get();

        if ($data->count() > 0) {
            foreach ($data as $d) {
                $price = $d->price_sell;
                $discount = $d->discount;
                $qty = $d->qty;
                $nett = $price * $qty;

                if ($discount > 0) {
                    $nett = ($price - (($discount / 100) * $price)) * $qty;
                }

                $total += $nett;
            }
        }

        return $total;
    }
}
