<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;

    /** @var string $dates */
    public $table = 'permissions';

    /** @var string $dates */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /** @var string $dates */
    protected $fillable = [
        'title',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return belongsToMany
     */
    public function roles(): belongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
