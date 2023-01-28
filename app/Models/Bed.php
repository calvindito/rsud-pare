<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bed extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'beds';

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
            $text = 'Laki - Laki';
        } else if ($type == 2) {
            $text = 'Perempuan';
        } else if ($type == 3) {
            $text = 'Campuran';
        } else if ($type == 4) {
            $text = 'Antrian';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }

    /**
     * roomSpace
     *
     * @return void
     */
    public function roomSpace()
    {
        return $this->belongsTo(RoomSpace::class);
    }
}
