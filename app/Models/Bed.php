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
     * roomSpace
     *
     * @return void
     */
    public function roomSpace()
    {
        return $this->belongsTo(RoomSpace::class);
    }

    public function type()
    {
        $type = $this->type;

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
}
