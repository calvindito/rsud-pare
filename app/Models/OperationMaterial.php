<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OperationMaterial extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operation_materials';

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
     * dispensaryItemStock
     *
     * @return void
     */
    public function dispensaryItemStock()
    {
        return $this->belongsTo(DispensaryItemStock::class);
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
     * operation
     *
     * @return void
     */
    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }
}
