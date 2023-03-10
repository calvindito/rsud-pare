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
    protected $appends = ['gender_format_result', 'type_format_result', 'no_medical_record', 'blood_group_format_result', 'greeted_format_result', 'marital_status_format_result'];

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

    /**
     * getNoMedicalRecordAttribute
     *
     * @return void
     */
    protected function getNoMedicalRecordAttribute()
    {
        $id = isset($this->attributes['id']) ? $this->attributes['id'] : null;

        return sprintf('%07s', $id);
    }

    /**
     * getBloodGroupFormatResultAttribute
     *
     * @return void
     */
    protected function getBloodGroupFormatResultAttribute()
    {
        $bloodGroup = isset($this->attributes['blood_group']) ? $this->attributes['blood_group'] : null;

        if ($bloodGroup == 1) {
            $text = 'A';
        } else if ($bloodGroup == 2) {
            $text = 'B';
        } else if ($bloodGroup == 3) {
            $text = 'AB';
        } else if ($bloodGroup == 4) {
            $text = 'O';
        } else {
            $text = 'Tidak Ada';
        }

        return $text;
    }

    /**
     * getMaritalStatusFormatResultAttribute
     *
     * @return void
     */
    protected function getMaritalStatusFormatResultAttribute()
    {
        $maritalStatus = isset($this->attributes['marital_status']) ? $this->attributes['marital_status'] : null;

        if ($maritalStatus == 1) {
            $text = 'Belum Menikah';
        } else if ($maritalStatus == 2) {
            $text = 'Menikah';
        } else if ($maritalStatus == 3) {
            $text = 'Cerai Hidup';
        } else if ($maritalStatus == 4) {
            $text = 'Cerai Mati';
        } else {
            $text = 'Tidak Ada';
        }

        return $text;
    }

    /**
     * getGreetedFormatResultAttribute
     *
     * @return void
     */
    protected function getGreetedFormatResultAttribute()
    {
        $greeted = isset($this->attributes['greeted']) ? $this->attributes['greeted'] : null;

        if ($greeted == 1) {
            $text = 'Tuan';
        } else if ($greeted == 2) {
            $text = 'Nyonya';
        } else if ($greeted == 3) {
            $text = 'Saudara';
        } else if ($greeted == 4) {
            $text = 'Nona';
        } else if ($greeted == 4) {
            $text = 'Anak';
        } else {
            $text = 'Tidak Ada';
        }

        return $text;
    }

    /**
     * province
     *
     * @return void
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * city
     *
     * @return void
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * district
     *
     * @return void
     */
    public function district()
    {
        return $this->belongsTo(District::class);
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

    /**
     * labRequest
     *
     * @return void
     */
    public function labRequest()
    {
        return $this->hasMany(LabRequest::class);
    }

    /**
     * radiologyRequest
     *
     * @return void
     */
    public function radiologyRequest()
    {
        return $this->hasMany(RadiologyRequest::class);
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

    /**
     * dispensaryRequest
     *
     * @return void
     */
    public function dispensaryRequest()
    {
        return $this->hasMany(DispensaryRequest::class);
    }

    /**
     * inpatientActive
     *
     * @return void
     */
    public function inpatientActive()
    {
        return $this->hasOne(Inpatient::class)->orderByDesc('date_of_entry');
    }

    /**
     * eating
     *
     * @return void
     */
    public function eating()
    {
        return $this->hasMany(Eating::class);
    }
}
