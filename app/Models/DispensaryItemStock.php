<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DispensaryItemStock extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dispensary_item_stocks';

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
    protected $appends = ['type_format_result'];

    /**
     * getTypeAttribute
     *
     * @return void
     */
    protected function getTypeFormatResultAttribute()
    {
        $type = isset($this->attributes['type']) ? $this->attributes['type'] : null;

        if ($type == 1) {
            $text = 'Masuk';
        } else if ($type == 2) {
            $text = 'Keluar';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }

    /**
     * dispensaryItem
     *
     * @return void
     */
    public function dispensaryItem()
    {
        return $this->belongsTo(DispensaryItem::class);
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
            $text = 'Pengajuan';
        } else if ($status == 2) {
            $text = 'Disetujui';
        } else if ($status == 3) {
            $text = 'Ditolak';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }

    /**
     * available
     *
     * @return int
     */
    public function available()
    {
        $stock = $this->qty;
        $sold = $this->sold();

        return $stock - $sold;
    }

    /**
     * sold
     *
     * @return int
     */
    public function sold()
    {
        return DispensaryItemStock::where('dispensary_item_id', $this->item_id)
            ->where('expired_date', $this->expired_date)
            ->where('type', 2)
            ->sum('qty');
    }
}
