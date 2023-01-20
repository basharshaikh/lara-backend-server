<?php

namespace App\Http\Controllers\Web;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function showAllProjects(){
        $data = Project::latest()->paginate(6);
        // var_dump($data);
        return view('projects', [
            'projects' => $data
        ]);
    }

    public function showEditForm(Project $project){
        return view('group.project.edit', [
            'project' => $project
        ]);
    }

    // Update projects
    public function updateProject(Request $request, Project $project){
        $data = $this->ProjectCustomResource($request);
        $project->update($data);
        return back()->with('message', 'Project updated successfully!');
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
        ];

        return $data;
    }
}
