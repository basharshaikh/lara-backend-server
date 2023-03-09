<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Client\BlogResource;
use App\Models\Blog;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    //
    public function allBlogs(Request $request){
        $search_key = $request['search'];
        $sort_key = $request['sort'];
        $cat_key = $request['category'];

        if($search_key){
            if($sort_key == 'oldest'){
                return BlogResource::collection(
                    Blog::where('title', 'like', '%' . $search_key . '%')
                    ->where('categories_id', 'like', '%' . $cat_key . '%')
                    ->oldest()
                    ->paginate(4)
                );
            } else {
                return BlogResource::collection(
                    Blog::where('title', 'like', '%' . $search_key . '%')
                    ->where('categories_id', 'like', '%' . $cat_key . '%')
                    ->latest()
                    ->paginate(4)
                );
            }

        } elseif($sort_key ) {
            if($sort_key == 'oldest'){
                return BlogResource::collection(
                    Blog::where('categories_id', 'like', '%' . $cat_key . '%')
                    ->oldest()
                    ->paginate(4)
                ); 
            } else {
                return BlogResource::collection(
                    Blog::where('categories_id', 'like', '%' . $cat_key . '%')
                    ->latest()
                    ->paginate(4)
                ); 
            } 
        } else {
            return BlogResource::collection(
                Blog::where('categories_id', 'like', '%' . $cat_key . '%')
                ->latest()
                ->paginate(4)
            ); 
        }

        
    }

    public function singleBlog(Blog $blog)
    {
        return new BlogResource($blog);
        // return $blog->with('user')->get();
    }

    // Get all categories
    public function blogAllCategories(){
        $catIDS = Blog::pluck('categories_id');
        $catIdArr = [];
        foreach ($catIDS as $value) {
          $catIdArr = array_merge($catIdArr, explode(',', $value));
        }
        $counted = array_count_values($catIdArr);
        $commonValues = array_filter($counted, function($value) {
            return $value > 1;
        });

        // 
        $catOutput = [];
        foreach($commonValues as $id => $cnt){
            $catName = BlogCategory::where('id', $id)->value('title');
            $catOutput[] = [
                'id' => $id,
                'name' => $catName,
                'count' => $cnt,
            ];
        }
        return $catOutput;
    }

    // 
    public function blogByCategory(){

    }
}
