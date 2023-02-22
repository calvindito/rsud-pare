<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DispensaryItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dispensary_items';

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
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->whereHas('dispensaryItemStock', function ($query) {
            $query->selectRaw("
                SUM(CASE WHEN type = '1' THEN qty END) as stock,
                SUM(CASE WHEN type = '2' THEN qty END) as sold
            ")->where('status', 2)->groupBy('dispensary_item_id')->havingRaw('stock > IF(sold > 0, sold, 0)');
        });
    }

    /**
     * stock
     *
     * @return void
     */
    public function stock($type = null)
    {
        $total = $this->dispensaryItemStock->where('type', 1)->where('status', 2)->sum('qty');
        $sold = $this->dispensaryItemStock->where('type', 2)->where('status', 2)->sum('qty');
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
     * dispensary
     *
     * @return void
     */
    public function dispensary()
    {
        return $this->belongsTo(Dispensary::class);
    }

    /**
     * item
     *
     * @return void
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * dispensaryItemStock
     *
     * @return void
     */
    public function dispensaryItemStock()
    {
        return $this->hasMany(DispensaryItemStock::class);
    }

    /**
     * fifoStock
     *
     * @return void
     */
    public function fifoStock()
    {
        $dispensaryItemStock = DispensaryItemStock::selectRaw("*, SUM(CASE WHEN type = '1' THEN qty END) as stock, SUM(CASE WHEN type = '2' THEN qty END) as sold")
            ->where('dispensary_item_id', $this->id)
            ->where('status', 2)
            ->groupBy('dispensary_item_id')
            ->havingRaw('stock > IF(sold > 0, sold, 0)')
            ->first();

        return $dispensaryItemStock;
    }
}
