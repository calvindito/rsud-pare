<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employees';

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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            try {
                $model->code = (new Self)->generateCode();
            } catch (\Exception $e) {
                abort(500, $e->getMessage());
            }
        });

        static::deleting(function ($query) {
            $query->user()->delete();
        });
    }

    /**
     * generateCode
     *
     * @return void
     */
    private function generateCode()
    {
        $data = Employee::selectRaw('RIGHT(code, 17) as code')
            ->orderByRaw('RIGHT(code, 17) DESC')
            ->take(1)
            ->get();

        if ($data->count() > 0) {
            $code = (int) $data[0]->code + 1;
        } else {
            $code = 1;
        }

        return 'PEG' . sprintf('%017s', $code);
    }

    /**
     * user
     *
     * @return void
     */
    public function user()
    {
        return $this->hasOne(User::class);
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
