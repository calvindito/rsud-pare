<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientGroup extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'patient_groups';

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
    protected $appends = ['car_free_ambulance_format_result', 'car_free_corpse_format_result'];

    /**
     * getCarFreeAmbulanceAttribute
     *
     * @return void
     */
    protected function getCarFreeAmbulanceFormatResultAttribute()
    {
        $carFreeAmbulance = isset($this->attributes['car_free_ambulance']) ? $this->attributes['car_free_ambulance'] : null;

        if ($carFreeAmbulance == true) {
            $text = 'Ya';
        } else if ($carFreeAmbulance == false) {
            $text = 'Tidak';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }

    /**
     * getCarFreeCorpseAttribute
     *
     * @return void
     */
    public function getCarFreeCorpseFormatResultAttribute()
    {
        $carFreeCorpse = isset($this->attributes['car_free_corpse']) ? $this->attributes['car_free_corpse'] : null;

        if ($carFreeCorpse == true) {
            $text = 'Ya';
        } else if ($carFreeCorpse == false) {
            $text = 'Tidak';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }
}
