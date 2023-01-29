<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChartOfAccount extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chart_of_accounts';

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
    protected $appends = ['fullname'];

    /**
     * getFullnameAttribute
     *
     * @return void
     */
    protected function getFullnameAttribute()
    {
        $id = isset($this->attributes['id']) ? $this->attributes['id'] : null;
        $name = isset($this->attributes['name']) ? $this->attributes['name'] : null;
        $parent = $this->fullname($id);
        $fullname = $parent . $name;

        return  $fullname;
    }

    /**
     * parent
     *
     * @return void
     */
    public function parent()
    {
        return $this->belongsTo(ChartOfAccount::class, 'parent_id');
    }

    /**
     * fullname
     *
     * @param  mixed $id
     * @return void
     */
    public function fullname($id = null)
    {
        $text = '';
        $data = ChartOfAccount::find($id);

        if ($data) {
            if ($data->parent && isset($data->parent_id)) {
                $text .= $data->parent->name . ' -> ';
                $this->fullname($data->parent->id);
            }
        }

        return $text;
    }

    /**
     * status
     *
     * @return void
     */
    public function status()
    {
        $status = $this->status;

        if ($status == 1) {
            $html = '<span class="badge bg-success">Aktif</span>';
        } else if ($status == 0) {
            $html = '<span class="badge bg-danger">Tidak Aktif</span>';
        } else {
            $html = '<span class="badge bg-warning">Invalid</span>';
        }

        return $html;
    }
}