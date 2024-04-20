<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes, HasFactory;

    /** @var string $table */
    public $table = 'clients';

    /** @var string $dates */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /** @var string $fillable */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return hasMany
     */
    public function appointments(): hasMany
    {
        return $this->hasMany(Appointment::class, 'client_id', 'id');
    }
}
