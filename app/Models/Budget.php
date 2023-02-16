<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'budgets';

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
     * code
     *
     * @return void
     */
    public function code()
    {
        return sprintf('%06s', $this->id);
    }

    /**
     * user
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
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
            $html = '<span class="badge bg-secondary">Draft</span>';
        } else if ($status == 2) {
            $html = '<span class="badge bg-primary">Sedang Diajukan</span>';
        } else if ($status == 3) {
            $html = '<span class="badge bg-warning">Direvisi</span>';
        } else if ($status == 4) {
            $html = '<span class="badge bg-success">Disetujui</span>';
        } else if ($status == 5) {
            $html = '<span class="badge bg-danger">Ditolak</span>';
        } else {
            $html = '<span class="badge bg-dark">Invalid</span>';
        }

        return $html;
    }

    /**
     * budgetDetail
     *
     * @return void
     */
    public function budgetDetail()
    {
        return $this->hasMany(BudgetDetail::class);
    }
}
