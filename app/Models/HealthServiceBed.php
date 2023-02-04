<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealthServiceBed extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'health_service_beds';

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
     * classType
     *
     * @return void
     */
    public function classType()
    {
        return $this->belongsTo(ClassType::class);
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
