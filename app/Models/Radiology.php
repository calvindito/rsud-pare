<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Radiology extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'radiologies';

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
    }

    /**
     * generateCode
     *
     * @return void
     */
    private function generateCode()
    {
        $data = Radiology::selectRaw('RIGHT(code, 3) as code')
            ->orderByRaw('RIGHT(code, 3) DESC')
            ->take(1)
            ->get();

        if ($data->count() > 0) {
            $code = (int) $data[0]->code + 1;
        } else {
            $code = 1;
        }

        return 'RAD-' . sprintf('%03s', $code);
    }

    /**
     * actionSupporting
     *
     * @return void
     */
    public function actionSupporting()
    {
        return $this->belongsTo(ActionSupporting::class)->withTrashed();
    }

    /**
     * radiologyAction
     *
     * @return void
     */
    public function radiologyAction()
    {
        return $this->hasOne(RadiologyAction::class)->withTrashed();
    }
}
