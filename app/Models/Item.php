<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items';

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
    protected $appends = ['type_format_result'];

    /**
     * getTypeAttribute
     *
     * @return void
     */
    protected function getTypeFormatResultAttribute()
    {
        $type = isset($this->attributes['type']) ? $this->attributes['type'] : null;

        if ($type == 1) {
            $text = 'Obat';
        } else if ($type == 2) {
            $text = 'Alat Kesehatan';
        } else {
            $text = 'Invalid';
        }

        return $text;
    }

    /**
     * scopeAvailable
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $calculatedWithRecipe
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query, $morphs = [])
    {
        return $query->whereHas('itemStock', function ($query) use ($morphs) {
            $query->where('stock', '>', 0);

            if ($morphs) {
                $query->orWhereHas('recipe', function ($query) use ($morphs) {
                    $query->where('recipeable_type', $morphs['type'])
                        ->where('recipeable_id', $morphs['id']);
                });
            }

            $query->take(1)->orderBy('expired_date');
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
     * itemStock
     *
     * @return void
     */
    public function itemStock()
    {
        return $this->hasMany(ItemStock::class);
    }

    /**
     * stock
     *
     * @return void
     */
    public function stock($type = null)
    {
        $stock = $this->itemStock->sum('stock');
        $sold = $this->itemStock->sum('sold');
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
        return $this->hasOne(ItemStock::class)->withTrashed()->oldest('expired_date');
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

    /**
     * itemUnit
     *
     * @return void
     */
    public function itemUnit()
    {
        return $this->belongsTo(ItemUnit::class);
    }
}
