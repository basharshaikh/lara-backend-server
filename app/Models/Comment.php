<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['comment', 'user_id', 'blog_id', 'parent_id'];

    // relation with user
    public function user(){
        return $this->belongsTo(User::class);
    }
    // relation with blog
    public function blog(){
        return $this->belongsTo(Blog::class);
    }
    // relation with replies
    public function replies(){
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
