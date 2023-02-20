<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectMinimalResource;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\UpdateProjectRequ;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if($user->can('Edit Project')){
            return ProjectMinimalResource::collection(Project::latest()->paginate(6));
        }
        return response("No access", 403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        $user = $request->user();
        if($user->can('Edit Project')){
            $data = $this->ProjectCustomResource($request);
            $project = Project::create($data);
            return response('Project inserted', 200);
        }
        return response("No access", 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $user = $request->user();
        if($user->can('Edit Project')){
            $data = $this->ProjectCustomResource($request);
            $project->update($data);
            return response('Project updated', 200);
        }
        return response("No access", 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $user = $request->user();
        if($user->can('Edit Project')){
            Project::find($id)->delete();
            return response('Project Deleted', 200);
        }
        return response("No access", 403);
    }

    // Project custom resource
    private function ProjectCustomResource($request){
        $valid = $request->validate([
            'title' => 'required|max:1000',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'label' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'video_overview' => 'nullable|string',
            'live_url' => 'nullable|string',
            'mediaID' => 'nullable|integer'
        ]);

        $data = [
            'title' => $valid['title'],
            'description' => $valid['description'],
            'status' => $valid['status'],
            'ingredients' => $valid['ingredients'],
            'label' => $valid['label'],
            'excerpt' => $valid['excerpt'],
            'featured_image' => $valid['mediaID'],
            'video_overview_url' => $valid['video_overview'],
            'project_live_url' => $valid['live_url'],
        ];

        return $data;
    }

    /**
     * Process the project image
     *
     * @param $base64_file
     * @param $file_name_full
     */
    private function process_img($base64_file, $file_name_full){
        $file_string = substr($base64_file, strpos($base64_file, ',') + 1);

        $file_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name_full);
        $file_ext = pathinfo($file_name_full, PATHINFO_EXTENSION);
        $file_name_slug = str_replace(" ","-", $file_name);
        if (preg_match('/^data:image\/(\w+);base64,/', $base64_file, $type)) {
            $file_ext = pathinfo($file_name_full, PATHINFO_EXTENSION);

            // Check if file is an image
            if (!in_array($file_ext, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }

        return [
            'file_string' => $file_string,
            'file_name_slug' => $file_name_slug,
            'file_ext' => $file_ext,
        ];
    }
}
