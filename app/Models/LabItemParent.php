<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabItemParent extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lab_item_parents';

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
     * parent
     *
     * @return void
     */
    public function parent()
    {
        return $this->belongsTo(LabItem::class, 'parent_id');
    }

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
