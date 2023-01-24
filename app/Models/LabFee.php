<?php

namespace App\Models;

use App\Models\LabItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabFee extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lab_fees';

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
     * labItem
     *
     * @return void
     */
    public function labItem()
    {
        return $this->belongsTo(LabItem::class);
    }

    /**
     * classType
     *
     * @return void
     */
    public function classType()
    {
        return $this->belongsTo(ClassType::class);
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
            $html = '<span class="badge bg-success">Aktif</span>';
        } else if ($status == false) {
            $html = '<span class="badge bg-danger">Tidak Aktif</span>';
        } else {
            $html = '<span class="badge bg-warning">Invalid</span>';
        }

        return $html;
    }
}
