<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OperatingRoomGroup extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operating_room_groups';

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
    protected $appends = ['group_format_result'];

    /**
     * getGroupAttribute
     *
     * @return void
     */
    protected function getGroupFormatResultAttribute()
    {
        $group = isset($this->attributes['group']) ? $this->attributes['group'] : null;

        if ($group == 1) {
            $text = 'KHUSUS';
        } else if ($group == 2) {
            $text = 'BESAR';
        } else if ($group == 3) {
            $text = 'SEDANG';
        } else if ($group == 4) {
            $text = 'KECIL';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }
}
