<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Employee extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    /** @var string $dates */
    public $table = 'employees';

    /** @var string $dates */
    protected $appends = [
        'photo',
    ];

    /** @var string $dates */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /** @var string $dates */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return hasMany
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    /**
     * @return hasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'employee_id', 'id');
    }

    /**
     * @return hasMany
     */
    public function getPhotoAttribute()
    {
        $file = $this->getMedia('photo')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
        }

        return $file;
    }

    /**
     * @return belongsToMany
     */
    public function services(): belongsToMany
    {
        return $this->belongsToMany(Service::class);
    }
}
