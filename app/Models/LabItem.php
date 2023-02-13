<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabItem extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lab_items';

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
     * labCategory
     *
     * @return void
     */
    public function labCategory()
    {
        return $this->belongsTo(LabCategory::class)->withTrashed();
    }

    /**
     * labItemGroup
     *
     * @return void
     */
    public function labItemGroup()
    {
        return $this->belongsTo(LabItemGroup::class)->withTrashed();
    }

    /**
     * labItemParent
     *
     * @return void
     */
    public function labItemParent()
    {
        return $this->hasOne(LabItemParent::class)->withTrashed();
    }

    /**
     * labFee
     *
     * @return void
     */
    public function labFee()
    {
        return $this->hasOne(LabFee::class)->withTrashed();
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
            $html = '<span class="badge bg-success">Aktif</span>';
        } else if ($status == 0) {
            $html = '<span class="badge bg-danger">Tidak Aktif</span>';
        } else {
            $html = '<span class="badge bg-warning">Invalid</span>';
        }

        return $html;
    }
}
