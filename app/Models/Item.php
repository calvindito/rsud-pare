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
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->whereHas('itemStock', function ($query) {
            $query->selectRaw("
                SUM(CASE WHEN type = '1' THEN qty END) as stock,
                SUM(CASE WHEN type = '2' THEN qty END) as sold
            ")->groupBy('item_id')->havingRaw('stock > IF(sold > 0, sold, 0)');
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
        $total = $this->itemStock->where('type', 1)->sum('qty');
        $sold = $this->itemStock->where('type', 2)->sum('qty');
        $available = $total - $sold;

        if ($type == 'sold') {
            $result = $sold;
        } else if ($type == 'available') {
            $result = $available;
        } else {
            $result = $total;
        }

        return $result;
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
