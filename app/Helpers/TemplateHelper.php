<?php

use App\Models\MediaLibrary;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// get featured image url from its id
if (! function_exists('featured_img_url')) {
    function featured_img_url($id) {
        if($id){
            $data = MediaLibrary::where('id', $id)->with('media', 'media')->first();
            $media_url = $data['media'][0]['original_url'];
            return $media_url;
        }
        return;
    }
}

// Get last project 
if(!function_exists('last_project')){
    function last_project(){
        $user = Auth::user();
        if($user->hasRole('Super-Admin')){
            return Project::latest()->first();
        }
        return;
    }
}