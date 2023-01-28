<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalService extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'medical_services';

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
    protected $appends = ['code_format_result'];

    /**
     * getCodeAttribute
     *
     * @return void
     */
    protected function getCodeFormatResultAttribute()
    {
        $code = isset($this->attributes['code']) ? $this->attributes['code'] : null;

        if ($code == 1) {
            $text = 'VISITE';
        } else if ($code == 2) {
            $text = 'VISITE IRD';
        } else if ($code == 3) {
            $text = 'KONSUL';
        } else if ($code == 4) {
            $text = 'KONSUL IRD';
        } else if ($code == 5) {
            $text = 'PDP';
        } else {
            $text = 'Invalid';
        }

        return $text;
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
