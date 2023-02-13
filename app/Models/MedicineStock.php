<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicineStock extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'medicine_stocks';

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
     * medicine
     *
     * @return void
     */
    public function medicine()
    {
        return $this->belongsTo(Medicine::class)->withTrashed();
    }

    /**
     * recipe
     *
     * @return void
     */
    public function recipe()
    {
        return $this->hasMany(Recipe::class);
    }
}
