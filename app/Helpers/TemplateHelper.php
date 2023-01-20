<?php

use App\Models\MediaLibrary;

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

// get default classes
if(!function_exists('defaut_class')){
    function defaut_class($field){
        $data = '';
        if($field == 'inputField'){
            $data = 'rounded-sm w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 text-sm mb-3';
        } else {
            $data = 'w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600';
        }

        return $data;
    }
}

