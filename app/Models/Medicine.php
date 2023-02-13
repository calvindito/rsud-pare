<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicine extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'medicines';

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
     * scopeAvailable
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $calculatedWithRecipe
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query, $calculatedWithRecipe = false)
    {
        return $query->whereHas('medicineStock', function ($query) use ($calculatedWithRecipe) {
            if ($calculatedWithRecipe) {
                $query->has('recipe')->orWhere('stock', '>', 0);
            } else {
                $query->where('stock', '>=', 0);
            }
        });
    }

    /**
     * distributor
     *
     * @return void
     */
    public function distributor()
    {
        return $this->belongsTo(Distributor::class)->withTrashed();
    }

    /**
     * medicineStock
     *
     * @return void
     */
    public function medicineStock()
    {
        return $this->hasMany(MedicineStock::class);
    }

    /**
     * stock
     *
     * @return void
     */
    public function stock($type = null)
    {
        $stock = $this->medicineStock->sum('stock');
        $sold = $this->medicineStock->sum('sold');
        $total = $stock + $sold;

        if ($type == 'sold') {
            $result = $sold;
        } else if ($type == 'available') {
            $result = $stock;
        } else {
            $result = $total;
        }

        return $result;
    }

    /**
     * fifoStock
     *
     * @return void
     */
    public function fifoStock()
    {
        return $this->hasOne(MedicineStock::class)->withTrashed()->oldest('expired_date');
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
