<?php

namespace App\Http\Resources;

use DateTime;
use App\Models\MediaLibrary;
use Illuminate\Support\Facades\URL;
use App\Http\Resources\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;



class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request); //When no need transformation
        
        $featured_id = $this->featured_image;
        if($featured_id){
            $featured = MediaLibrary::where('id', $featured_id)->with('media', 'media')->first();
            $featured = URL::to('/').'/storage/'.$featured->id.'/'.$featured->name;
        } else {
            $featured = '';
        }
        

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'ingredients' => $this->ingredients,
            'label' => $this->label,
            'excerpt' => $this->excerpt,
            'mediaUrl' => $featured,
            'mediaID' => $featured_id,
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d H:i:s'),
        ];
    }
}
