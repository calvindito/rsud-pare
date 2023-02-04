<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inpatient extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inpatients';

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
            $text = 'Umum';
        } else if ($type == 2) {
            $text = 'Jamkesda';
        } else if ($type == 3) {
            $text = 'BPJS Tenaga Kerja';
        } else if ($type == 4) {
            $text = 'In Health';
        } else if ($type == 5) {
            $text = 'JR Jamkesda';
        } else if ($type == 6) {
            $text = 'JR BPJS';
        } else if ($type == 7) {
            $text = 'JR Umum';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }

    /**
     * roomType
     *
     * @return void
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * functionalService
     *
     * @return void
     */
    public function functionalService()
    {
        return $this->belongsTo(FunctionalService::class);
    }
}
