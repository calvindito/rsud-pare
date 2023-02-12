<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'units';

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
            $text = 'Rawat Inap';
        } else if ($type == 2) {
            $text = 'Rawat Jalan';
        } else if ($type == 3) {
            $text = 'Penunjang';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }

    /**
     * outpatientPoly
     *
     * @return void
     */
    public function outpatientPoly()
    {
        return $this->hasMany(OutpatientPoly::class);
    }

    /**
     * operation
     *
     * @return void
     */
    public function operation()
    {
        return $this->hasMany(Operation::class);
    }
}
