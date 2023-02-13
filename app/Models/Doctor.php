<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doctors';

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
     * getTypeFormatResultAttribute
     *
     * @return void
     */
    public function getTypeFormatResultAttribute()
    {
        $type = isset($this->attributes['type']) ? $this->attributes['type'] : null;

        if ($type == 1) {
            $text = 'AHLI';
        } else if ($type == 2) {
            $text = 'GIGI';
        } else if ($type == 3) {
            $text = 'UMUM';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }

    /**
     * operation
     *
     * @return void
     */
    public function operation()
    {
        return $this->hasMany(Operation::class, 'doctor_operation_id');
    }
}
