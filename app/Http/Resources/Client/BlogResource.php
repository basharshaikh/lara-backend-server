<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\MediaLibrary;
use App\Models\BlogCategory;
use App\Models\User;
use App\Models\Comment;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $featured_id = $this->featured_image;
        if($featured_id){
            $featured = MediaLibrary::where('id', $featured_id)->with('media', 'media')->first();
            $featured = $featured['media'][0]['original_url'];
        } else {
            $featured = '';
        }

        $cat_ids = explode(",", $this->categories_id);
        $cat_info = BlogCategory::findMany($cat_ids);
        $cats_id = BlogCategory::findMany($cat_ids, 'id');
        
        $cats_id_arr = [];
        foreach($cats_id as $id){
            $cats_id_arr[] = $id->id;
        }

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status,
            'excerpt' => $this->excerpt,
            'mediaUrl' => $featured,
            'mediaID' => $featured_id,
            'catsInfo' => $cat_info,
            'catID' => $cats_id_arr,
            'author' => User::findOrFail($this->user_id)->only('id', 'name', 'email'),
            'comments' => Comment::where([
                ['blog_id', $this->id],
                ['parent_id', null]
            ])->with('user:id,name', 'replies.user:id,name', 'replies.replies.user:id,name')
            ->orderBy('created_at', 'desc')
            ->get()
        ];
    }
}
