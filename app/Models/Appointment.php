<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes, HasFactory;

    /** @var string $table */
    public $table = 'appointments';

    /** @var $dates */
    protected $dates = [
        'start_time',
        'created_at',
        'updated_at',
        'deleted_at',
        'finish_time',
    ];

    /** @var $fillable */
    protected $fillable = [
        'price',
        'comments',
        'client_id',
        'start_time',
        'created_at',
        'updated_at',
        'deleted_at',
        'employee_id',
        'finish_time',
    ];

    /**
     * @return belongsTo 
     */
    public function client(): belongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * @return belongsTo 
     */
    public function employee(): belongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * @return string 
     */
    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @return belongsToMany 
     */
    public function services(): belongsToMany
    {
        return $this->belongsToMany(Service::class);
    }
}
