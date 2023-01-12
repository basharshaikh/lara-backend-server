<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Client\BlogResource;
use App\Models\Blog;

class BlogController extends Controller
{
    //
    public function allBlogs(){
        return BlogResource::collection(Blog::latest()->paginate(4));
    }

    public function singleBlog(Blog $blog)
    {
        return new BlogResource($blog);
        // return $blog->with('user')->get();
    }
}
