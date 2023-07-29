<?php

namespace App\Http\Repositories;

use App\Events\RequestForDoctor;
use App\Models\Doctor;
use App\Models\MyRequest;
use App\Models\Project;
use App\Models\Student;
use App\Notifications\Notifiy;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RequestRepository
{
    public function search(Request $request, ?MyRequest $myRequest = null)
    {
        $myRequest = MyRequest::query();

        if($request->filled('id'))
        {
            $myRequest->where('id',$request->id);
        }

        if($request->filled('type'))
        {
            $myRequest->where('type',$request->id);
        }

        return $myRequest;
    }
    public function fill(Request $request, ?MyRequest $myRequest = null)
    {

        if (!isset($myRequest)) {

            $myrequest = new MyRequest();
        }
        try {
            $myrequest->created_by = $request->created_by;

            $myrequest->type = $request->type;
            $myrequest->project_id = $request->project_id;
            $myrequest->request_to = $request->request_to;

            return $myrequest->save();
        } catch (Exception $e) {
dd($e);
            return false;
        }
    }



    public function getRequest(Request $request)
    {
        try {

            $myRequest = MyRequest::with(['student' => function ($q) {
                $q->select('id', 'name','email');
            }, 'project' => function ($q) {
                $q->select('id', 'name');
            }])->where('request_to', $request->request_to)->Where('type', $request->type);

            return  $myRequest;
        } catch (Exception $e) {
            return $e;
        }
    }


    // public function getAcceptedRequest(Request $request, MyRequest $myRequest)

    // {
    //     $requests = $myRequest::query()->where('status', 'approved')->andWhere('type', 'doctor');

    //     return  sendResponse($requests, 'success');
    // }

    public function  assignApprovedTeamToProject(MyRequest $myRequest)
    {
        $students = Student::query()->select('id')->where('leader_id',$myRequest->created_by)->orWhere('id',$myRequest->created_by)
        ->get()->pluck('id')->toArray();

       return Student::query()->whereIn('id',$students)->update(['project_id'=>$myRequest->project_id]);

    }


}
