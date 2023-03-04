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
        } else if ($type == 3) {
            $text = 'Lainnya';
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
                SUM(CASE WHEN type = '2' THEN qty END) as cut
            ")->groupBy('item_id')->havingRaw('stock > IF(cut > 0, cut, 0)');
        });
    }

    /**
     * distributor
     *
     * @return void
     */
    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
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
        $cut = $this->itemStock->where('type', 2)->sum('qty');
        $available = $total - $cut;

        if ($type == 'cut') {
            $result = $cut;
        } else if ($type == 'available') {
            $result = $available;
        } else {
            $result = $total;
        }

        return $result;
    }

    /**
     * dispensaryRequest
     *
     * @return void
     */
    public function dispensaryRequest()
    {
        return $this->hasMany(DispensaryRequest::class);
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

    /**
     * installation
     *
     * @return void
     */
    public function installation()
    {
        return $this->belongsTo(Installation::class);
    }

    /**
     * budgetPlanning
     *
     * @return void
     */
    public function budgetPlanning()
    {
        return $this->hasMany(BudgetPlanning::class);
    }

    /**
     * newStock
     *
     * @return void
     */
    public function newStock()
    {
        return $this->hasOne(ItemStock::class)->latest();
    }
}
