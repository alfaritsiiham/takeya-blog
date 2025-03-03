<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model{
    use HasSlug;
    use HasFactory;

    const STATUS_DRAFT = "Draft";
    const STATUS_SCHEDULED = "Scheduled";
    const STATUS_PUBLISHED = "Published";

    protected $casts = [
        'publish_date' => 'datetime',
    ];

    public function getSlugOptions() : SlugOptions{
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function user(){
        return $this->belongsTo(User::class, 'author');
    }
}
