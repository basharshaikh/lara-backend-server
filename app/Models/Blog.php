<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Blog extends Model
{
    use HasFactory;
    use HasSlug;
    
    protected $table = 'blogs';
    
    protected $fillable = [
        'user_id', 
        'title', 
        'slug', 
        'description', 
        'status', 
        'excerpt', 
        'featured_image', 
        'categories_id'
    ];

    // relationships with user
    public function user(){
        return $this->belongsTo(User::class);
    }

    // relation with comments
    public function comments(){
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
