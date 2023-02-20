<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;


class BlogCategoryController extends Controller
{
    // get validated category data
    public function categoryData(Request $request){
        $validated = $request->validate([
            'title' => 'required|max:1000',
            'description' => 'nullable|string'
        ]);
        return $validated;
    }

    //add blog category
    public function addBlogCategory(Request $request){
        $user = $request->user();
        if($user->can('Edit Category')){
            $data = $this->categoryData($request);
            $cat = BlogCategory::create($data);
    
            return response('Category inserted', 200);
        }
        return response('You don\'t have permission yet!', 403);
    }

    // Get all categories
    public function getAllCategories(){
        return BlogCategory::latest()->paginate(6);
    }

    // Get single category
    public function getSingleCat(BlogCategory $blogCat){
        return $blogCat;
    }

    // update single category
    public function updateCategory(Request $request, BlogCategory $blogCat){
        $user = $request->user();
        if($user->can('Edit Category')){
            $data = $this->categoryData($request);
            $blogCat->update($data);
            return response('Category Updated', 200);
        }
        return response('You don\'t have permission yet!', 403);
    }

    // delete the category
    public function deleteBlogCat(BlogCategory $blogCat, Request $request){
        $user = $request->user();
        if($user->can('Delete Category')){
            $blogCat->delete();
            return response('Category Deleted', 200);
        }
        return response('You don\'t have permission yet!', 403);
    }
}
