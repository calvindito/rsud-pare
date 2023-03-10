<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Action extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'actions';

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
     * inpatientActionLimit
     *
     * @return void
     */
    public function inpatientActionLimit()
    {
        return $this->hasMany(InpatientActionLimit::class);
    }

    /**
     * emergencyDepartmentActionLimit
     *
     * @return void
     */
    public function emergencyDepartmentActionLimit()
    {
        return $this->hasMany(EmergencyDepartmentActionLimit::class);
    }
}
