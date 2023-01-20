<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientGroup extends Model
{
    use HasFactory;

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
     * carFreeAmbulance
     *
     * @return void
     */
    public function carFreeAmbulance()
    {
        $carFreeAmbulance = $this->car_free_ambulance;

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
     * carFreeCorpse
     *
     * @return void
     */
    public function carFreeCorpse()
    {
        $carFreeCorpse = $this->car_free_corpse;

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
