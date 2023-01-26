<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

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
    public static function booted()
    {
        static::deleting(function ($query) {
            $query->roleAccess()->delete();
        });
    }

    /**
     * roleAccess
     *
     * @return void
     */
    public function roleAccess()
    {
        return $this->hasMany(RoleAccess::class);
    }
}
