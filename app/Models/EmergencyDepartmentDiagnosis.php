<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmergencyDepartmentDiagnosis extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'emergency_department_diagnoses';

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
     * type
     *
     * @return void
     */
    public function type()
    {
        $type = $this->type;

        if ($type == 1) {
            $text = 'Diagnosa';
        } else if ($type == 2) {
            $text = 'Tindakan';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }

    /**
     * emergencyDepartment
     *
     * @return void
     */
    public function emergencyDepartment()
    {
        return $this->belongsTo(EmergencyDepartment::class);
    }
}
