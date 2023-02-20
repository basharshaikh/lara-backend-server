<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Models\MediaLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class MediaLibraryController extends Controller
{
    //add media 
    public function addMedia(Request $request){
        $base64_file_arr = $request->base;
        $file_name_full_arr = $request->name;
        $count = -1;
        foreach($base64_file_arr as $base64_file){
            $count++;
            $file_info = $this->process_img($base64_file, $file_name_full_arr[$count]);
            $file_string = $file_info['file_string'];

            $data = [
                'name' => $file_info['file_name_slug'].'.'.$file_info['file_ext'],
                'alt' => $file_info['file_name_slug'],
                'size' => $file_info['file_size'],
            ];

            if($data['size'] >= (1024 * 10)){
                return response([
                    'error' => 'The Provided Crendentials are not correct'
                ], 422);
            } else {
                $media = MediaLibrary::create($data);
                $media->addMediaFromBase64($file_string)->usingFileName($data['name'])->toMediaCollection();
            }
        }
        return response('Media Uploaded!', 200);
    }

    // Get all Media 
    public function getAllMedia(){
        $medias = MediaLibrary::latest()->with('media', 'media')->paginate(32);
        
        // $posts = Post::paginate(10);
        $medias->map(function ($media) {
            $media->media_url = URL::to('/').'/storage/'.$media->id.'/'.$media->name;
            return $media;
        });
        
        return $medias;
    }

    // Get single Media 
    public function getSingleMedia($id){
        $singleMedia = MediaLibrary::where('id', $id)->with('media', 'media')->first();

        return [
            'alt' => $singleMedia['alt'],
            'url' => URL::to('/').'/storage/'.$singleMedia['id'].'/'.$singleMedia['name']
        ];
    }

    // Delete single media
    public function DeleteSingleMedia($id, MediaLibrary $mediaLibrary, Request $request){
        $user = $request->user();
        if($user->can('Delete Media')){
            $data = MediaLibrary::find($id);
            $data->delete();
            return response("Media deleted!", 200);
        }
        return response('You don\'t have permission yet!', 403);
    }


    /**
     * Process the project image
     *
     * @param $base64_file
     * @param $file_name_full
     */
    private function process_img($base64_file, $file_name_full){
        $file_string = substr($base64_file, strpos($base64_file, ',') + 1);
        $file_size_kb = (strlen(base64_decode($file_string)) / 1024);

        $file_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name_full);
        $file_ext = pathinfo($file_name_full, PATHINFO_EXTENSION);
        $file_name_slug = str_replace(" ","-", $file_name);
        if (preg_match('/^data:image\/(\w+);base64,/', $base64_file, $type)) {
            $file_ext = pathinfo($file_name_full, PATHINFO_EXTENSION);

            // Check if file is an image
            if (!in_array($file_ext, ['jpg', 'jpeg', 'gif', 'png', 'mkv'])) {
                throw new \Exception('invalid image type');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }

        return [
            'file_string' => $file_string,
            'file_name_slug' => $file_name_slug.'-'.Str::random(4),
            'file_ext' => $file_ext,
            'file_size' => $file_size_kb,
        ];
    }
}
