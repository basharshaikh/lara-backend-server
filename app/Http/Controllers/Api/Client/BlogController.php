<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Client\BlogResource;
use App\Models\Blog;

class BlogController extends Controller
{
    //
    public function allBlogs(Request $request){
        $search_key = $request['search'];
        $sort_key = $request['sort'];

        if($search_key){
            if($sort_key == 'oldest'){
                return BlogResource::collection(
                    Blog::where('title', 'like', '%' . $search_key . '%')
                    ->oldest()
                    ->paginate(4)
                );
            } else {
                return BlogResource::collection(
                    Blog::where('title', 'like', '%' . $search_key . '%')
                    ->latest()
                    ->paginate(4)
                );
            }

        } elseif($sort_key ) {
            if($sort_key == 'oldest'){
                return BlogResource::collection(Blog::oldest()->paginate(4)); 
            } else {
                return BlogResource::collection(Blog::latest()->paginate(4)); 
            } 
        } else {
            return BlogResource::collection(Blog::latest()->paginate(4)); 
        }
        
    }

    public function singleBlog(Blog $blog)
    {
        return new BlogResource($blog);
        // return $blog->with('user')->get();
    }
}
