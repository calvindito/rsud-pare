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
    protected $table = 'dispensary_items';

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
     * dispensaryItem
     *
     * @return void
     */
    public function dispensaryItem()
    {
        return $this->belongsTo(DispensaryItem::class);
    }

    /**
     * type
     *
     * @return void
     */
    public function type()
    {
        $type = $this->type;

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
}
