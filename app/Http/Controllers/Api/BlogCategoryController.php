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
        $data = $this->categoryData($request);
        $cat = BlogCategory::create($data);

        return response('Category inserted', 200);
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

        $data = $this->categoryData($request);
        $blogCat->update($data);
        return response('Category Updated', 200);
    }

    // delete the category
    public function deleteBlogCat(BlogCategory $blogCat){
        $blogCat->delete();
        return response('Category Deleted', 200);
    }
}
