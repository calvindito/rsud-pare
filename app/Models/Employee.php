<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

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
     * boot
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->code = (new Self)->generateCode();
            } catch (\Exception $e) {
                abort(500, $e->getMessage());
            }
        });
    }

    /**
     * generateCode
     *
     * @return void
     */
    private function generateCode()
    {
        $data = Employee::selectRaw('RIGHT(code, 6) as code')
            ->orderByRaw('RIGHT(code, 6) DESC')
            ->take(1)
            ->get();

        if ($data->count() > 0) {
            $code = (int) $data[0]->code + 1;
        } else {
            $code = 1;
        }

        return 'PEG' . sprintf('%06s', $code);
    }

    /**
     * status
     *
     * @return void
     */
    public function status()
    {
        $status = $this->status;

        if ($status == true) {
            $html = '<span class="badge bg-success">Aktif</span>';
        } else if ($status == false) {
            $html = '<span class="badge bg-danger">Tidak Aktif</span>';
        } else {
            $html = '<span class="badge bg-warning">Invalid</span>';
        }

        return $html;
    }
}
