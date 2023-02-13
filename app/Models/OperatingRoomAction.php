<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OperatingRoomAction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operating_room_actions';

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
     * classType
     *
     * @return void
     */
    public function classType()
    {
        return $this->belongsTo(ClassType::class)->withTrashed();
    }

    /**
     * operatingRoomActionType
     *
     * @return void
     */
    public function operatingRoomActionType()
    {
        return $this->belongsTo(OperatingRoomActionType::class)->withTrashed();
    }

    /**
     * operatingRoomGroup
     *
     * @return void
     */
    public function operatingRoomGroup()
    {
        return $this->belongsTo(OperatingRoomGroup::class)->withTrashed();
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
