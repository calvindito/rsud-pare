<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChartOfAccount extends Model
{
    use HasFactory, SoftDeletes;

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
     * budget
     *
     * @return void
     */
    public function budget()
    {
        return $this->hasMany(Budget::class);
    }

    /**
     * fullname
     *
     * @param  mixed $id
     * @param  mixed $text
     * @return void
     */
    public function fullname($id = null, $text = [])
    {
        $data = ChartOfAccount::find($id);

        if ($data) {
            if ($data->parent && isset($data->parent_id)) {
                $text[] = $data->parent->name;
                return $this->fullname($data->parent->id, $text);
            }
        }

        if (count($text) > 0) {
            $sequence = collect(array_reverse($text))->implode(' -> ') . ' -> ';
        } else {
            $sequence = null;
        }

        return $sequence;
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

    public function sub()
    {
        return $this->hasMany(ChartOfAccount::class, 'parent_id')->with('sub');
    }
}
