<?php

namespace App\Http\Controllers\api\project;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ProjectRepository;
use App\Http\Requests\CreateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(private ProjectRepository $projectRepository)
    {
    }

    public function index(Request $request)
    {
        $projects =  $this->projectRepository->search($request)->get();

        return sendResponse($projects, "All Projects");
    }



    public function store(Request $request)
    {
        $handleSkills = [];
        $skills = preg_split('/[, ]/', $request->skills);
       for($i=0;$i<count( $skills);$i++) {
          $handleSkills['skill'.$i+1] = $skills[$i];
       }

       $request->merge(['skills'=>$handleSkills]);

        if (($key = array_search(' ', $skills)) !== false || ($key = array_search(',', $skills)) !== false  ) {
            unset($array[$key]);
        }


        if ($this->projectRepository->fill($request) != true) {
            sendError($this->projectRepository->fill($request), 'something is Wrong');
        }

        return sendResponse('done', 'Project Created Successfully');
    }

    public function update(Request $request, $project)
    {
        $projectModel = Project::find($project);

        if ($this->projectRepository->fill($request, $projectModel) != true) {
            sendError($this->projectRepository->fill($request), 'something is Wrong');
        }

        return sendResponse('Project Updated Successfully', 'Project Updated Successfully');
    }

    public function destroy(Request $request, $project)
    {
        $projectModel = Project::find($project);

       if(  $projectModel != null) {

           if ($this->projectRepository->deleteProject($request, $projectModel) != true) {
               sendError('something is Wrong', 'something is Wrong');
           }
           return sendResponse('Project deleted', 'Project deleted Successfully');
       }
       return  sendError('this project not exist', 'this project not exist');


    }
}
