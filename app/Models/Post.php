<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Sluggable;

    public $table = 'posts';

    protected $appends = [
        'photo',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'sport_id',
        'event_id',
        'full_text',
        'published',
        'created_at',
        'updated_at',
        'deleted_at',
        'slug',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');

    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
        $this->addMediaConversion('front')->width(1050)->height(700);
        $this->addMediaConversion('thumb_front')->width(350)->height(230);

    }

    public function sport()
    {
        return $this->belongsTo(Sport::class, 'sport_id');

    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');

    }

    public function getPhotoAttribute()
    {
        $file = $this->getMedia('photo')->last();

        if ($file) {
            $file->url         = $file->getUrl();
            $file->thumbnail   = $file->getUrl('thumb');
            $file->front       = $file->getUrl('front');
            $file->thumb_front = $file->getUrl('thumb_front');
        }

        return $file;

    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

}
