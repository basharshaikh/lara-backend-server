<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Resources\ProjectResource;

class ProjectController extends Controller
{
    // Get all projects
    public function allProjects(){
        $data = ProjectResource::collection(Project::latest()->paginate(4));
        return $data;
    }
    // Get all projects by one 
    public function allProjectsByOne(){
        $data = ProjectResource::collection(Project::latest()->paginate(1));
        return $data;
    }

    // Get single project
    public function getSingleProject(Project $project){
        return new ProjectResource($project);
    }
}
