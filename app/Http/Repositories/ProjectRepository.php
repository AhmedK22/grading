<?php
namespace App\Http\Repositories;

use App\Models\Doctor;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProjectRepository
{
    public function search(Request $request)
    {
        $projects = Project::with(['doctors'=>function($q){
            $q->select('name','email');
        }]);

        if($request->filled('id')) {
            $projects->where('id', $request->id);
        }
         if($request->filled('type')) {

            $projects->where('type', $request->type);
        }
        return $projects;
    }



    public function fill(Request $request, ?Project $project = null)
    {
        if (!isset($project)) {
            $project = new Project();
        }

        $project->name = $request->name;
        $project->objective = $request->objective;
        $project->description = $request->description;
        $project->num_of_students = $request->number_of_students;
        $project->max_mark = $request->max_mark;
        $project->skills = $request->skills;

        $project->project_type = $request->project_type;
        $project->background = $request->background;
        $project->type = $request->type;

        if ($request->filled('date_of_exam')) {
            $project->date_of_exam = $request->date_of_exam;
        }

        if ($request->filled('status')) {
            $project->status = $request->status;
        }

        if ($request->filled('lastStatus')) {
            $project->lastStatus = $request->lastStatus;
        }
        
        return  $project->save();
    }

    public function deleteProject(Request $request,Project $project)
    {
       return $project->delete();
    }
}
