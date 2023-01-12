<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{

    // Get all blog
    public function blogGetAll(Request $request){
        $user = $request->user();

        // for admin
        if($user->hasRole('Super-Admin')){
            return BlogResource::collection(Blog::latest()->paginate(3));
        }

        // for blogger
        if($user->can('edit_blog')){
            return BlogResource::collection(Blog::where('user_id', $user->id)->paginate(3));
        }
        
        return;
    }

    // Get Single blog
    public function getSingleBlog($id){
        return new BlogResource(Blog::find($id));
        // return Blog::findOrFail($id);
    }

    // Insert a blog
    public function addBlog(Request $request){
        $blog = Blog::create($this->BlogCustomResource($request));
        return response('Blog inserted successfully', 200);
    }

    // Update Blog
    public function updateSingleBlog($id, Blog $blog, Request $request){
        Blog::find($id)->update($this->BlogCustomResource($request));
        return response('Blog Updated', 200);
    }

    // Delete blog
    public function deleteSingleBlog($id){
        Blog::find($id)->delete();
        return response('Blog Deleted', 200);
    }

    // Blog comments
    public function blogComments(){
        $data = Blog::first()->with('user', 'comments.replies')->first();
        // $user = User::find(1);
 
        dd($data->toArray());
    }

    // Blog custom resource
    private function BlogCustomResource($request){
        
        $valid = $request->validate([
            'title' => 'required|max:1000',
            'description' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'status' => 'nullable|string',
            'catID' => 'nullable|array',
            'mediaID' => 'nullable|integer',
        ]);

        $data = [
            'title' => $valid['title'],
            'user_id' => $request->user()->id,
            'description' => $valid['description'],
            'excerpt' => $valid['excerpt'],
            'status' => $valid['status'],
            'featured_image' => $valid['mediaID'],
            'categories_id' => implode(',', $valid['catID']) 
        ];

        return $data;
    }
}
