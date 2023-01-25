<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabItemCondition extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lab_item_conditions';

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
     * The "booted" method of the model.
     *
     * @return void
     */
    public static function booted()
    {
        static::deleting(function ($query) {
            $query->labItemConditionDetail()->delete();
        });
    }

    /**
     * labItemConditionDetail
     *
     * @return void
     */
    public function labItemConditionDetail()
    {
        return $this->hasMany(LabItemConditionDetail::class);
    }
}
