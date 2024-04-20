<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes, HasFactory;

    /** @var string $dates */
    public $table = 'services';

    /** @var string $dates */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /** @var string $dates */
    protected $fillable = [
        'name',
        'price',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return belongsToMany
     */
    public function employees(): belongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }

    /**
     * @return belongsToMany
     */
    public function appointments(): belongsToMany
    {
        return $this->belongsToMany(Appointment::class);
    }
}
