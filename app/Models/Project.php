<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Project extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'projects';

    protected $fillable = ['title', 'description', 'status', 'ingredients', 'label', 'excerpt', 'featured_image'];

}


