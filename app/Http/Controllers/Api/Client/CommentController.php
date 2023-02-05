<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    //
    public function getBlogComments($blog_id, Request $request)
    {
        // $data = new CommentResource(Comment::latest());
    }

    public function postComment(Request $request){
        $data = $this->CommentCustomResource($request);
        $comment = Comment::create($data);
        
        return $comment;
    }


    // Comment custom resource
    private function CommentCustomResource($request){
        $valid = $request->validate([
            'commentText' => 'required|max:1000',
            'blogID' => 'required|integer',
            'parentID' => 'nullable|integer',
            'userId' => 'required|integer'
        ]);

        $data = [
            'comment' => $valid['commentText'],
            'user_id' => $valid['userId'],
            'blog_id' => $valid['blogID'],
            'parent_id' => $valid['parentID']
        ];

        return $data;
    }
}
