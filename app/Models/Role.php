<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    /** @var string $dates */
    public $table = 'roles';

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
    public function users(): belongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return belongsToMany
     */
    public function permissions(): belongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
}
