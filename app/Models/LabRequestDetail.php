<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabRequestDetail extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lab_request_details';

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
     * labItem
     *
     * @return void
     */
    public function labItem()
    {
        return $this->belongsTo(LabItem::class);
    }

    /**
     * labItemParent
     *
     * @return void
     */
    public function labItemParent()
    {
        return $this->belongsTo(LabItemParent::class);
    }

    /**
     * labItemCondition
     *
     * @return void
     */
    public function labItemCondition()
    {
        return $this->belongsTo(LabItemCondition::class);
    }

    /**
     * labRequest
     *
     * @return void
     */
    public function labRequest()
    {
        return $this->belongsTo(LabRequest::class);
    }
}
