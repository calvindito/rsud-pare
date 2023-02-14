<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'patients';

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
    protected $appends = ['gender_format_result', 'type_format_result', 'no_medical_record'];

    /**
     * getGenderAttribute
     *
     * @return void
     */
    protected function getGenderFormatResultAttribute()
    {
        $gender = isset($this->attributes['gender']) ? $this->attributes['gender'] : null;

        if ($gender == 1) {
            $text = 'Laki - Laki';
        } else if ($gender == 2) {
            $text = 'Perempuan';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }

    /**
     * getTypeAttribute
     *
     * @return void
     */
    protected function getTypeFormatResultAttribute()
    {
        $type = isset($this->attributes['type']) ? $this->attributes['type'] : null;

        if ($type == 1) {
            $text = 'Mandiri';
        } else if ($type == 2) {
            $text = 'Online';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }

    protected function getNoMedicalRecordAttribute()
    {
        $totalData = strlen(Patient::count());
        $id = isset($this->attributes['id']) ? $this->attributes['id'] : null;

        return sprintf('%0' . $totalData . 's', $id);
    }

    /**
     * province
     *
     * @return void
     */
    public function province()
    {
        return $this->belongsTo(Province::class)->withTrashed();
    }

    /**
     * city
     *
     * @return void
     */
    public function city()
    {
        return $this->belongsTo(City::class)->withTrashed();
    }

    /**
     * district
     *
     * @return void
     */
    public function district()
    {
        return $this->belongsTo(District::class)->withTrashed();
    }

    /**
     * outpatient
     *
     * @return void
     */
    public function outpatient()
    {
        return $this->hasMany(Outpatient::class);
    }

    /**
     * inpatient
     *
     * @return void
     */
    public function inpatient()
    {
        return $this->hasMany(Inpatient::class);
    }

    /**
     * emergencyDepartment
     *
     * @return void
     */
    public function emergencyDepartment()
    {
        return $this->hasMany(EmergencyDepartment::class);
    }

    /**
     * religion
     *
     * @return void
     */
    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }
}
