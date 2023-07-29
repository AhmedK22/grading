<?php

namespace App\Http\Services;

use App\Events\RequestForDoctor;
use App\Http\Repositories\ProjectRepository;
use App\Http\Repositories\RequestRepository;
use App\Http\Repositories\StudentRepository;
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


class RequestService
{
    public function __construct(
        public StudentRepository $studentRepository,
        public RequestRepository $requestRepository,
        public ProjectRepository $projectRepository,


    ) {
    }
    public function sendNotifyForDoctor(Request $request)
    {
        $doctor = Doctor::query()->where('id', $request->request_to)->first();

        event(new RequestForDoctor($doctor));
    }
    public function checkIfStudentLeader(Request|MyRequest $request)
    {
        $newRequest = new Request();
        $requestForLeaderId = $newRequest->merge(['id' => $request->created_by]);

        $student =  $this->studentRepository->search($requestForLeaderId)->first();


        if ($student->isleader == false) {
            return false;
        }

        return true;
    }
    public function assignApprovedTeamToProject($myRequest)
    {
        return $this->requestRepository->assignApprovedTeamToProject($myRequest);
    }
    public function isAteamMember(Request $request)
    {
        $newRequest = new Request();
        $newRequest->merge(['id' => $request->created_by]);
        $student = $this->studentRepository->search($newRequest)->first();
        if ($student?->leader_id != null) {
            return true;
        }
        return false;
    }
    public function  createRequest(Request $request)
    {

        if (!$this->isAteamMember($request)) {

            $action = 'create' . ucfirst($request->type) . 'Request';

            return $this->$action($request);
        }

        return sendError('you have a team leader', 'you have a team leader');
    }

    public function createDoctorRequest(Request $request)
    {
        if (!$this->checkIfStudentLeader($request)) {

            return sendError("You Aren't  A leader", "You Aren't  A leader");
        }
        if ($this->requestRepository->fill($request) != true) {

            return sendError("something is wrong", "something is wrong");
        }

        return sendResponse('requests have been sent', 'requests have been sent');
    }

    public function createStudentRequest(Request $request)
    {
        if ($this->requestRepository->fill($request) != true) {
            return sendError("something is wrong", "something is wrong");
        }
        return sendResponse('requests have been sent', 'requests have been sent');
    }



    public function acceptRequest(Request $request, $request_id)
    {

        $request->merge(['id' => $request_id]);
        $myRequest = $this->requestRepository->search($request)->first();
        $action = 'accept' . ucfirst($myRequest->type) . 'Request';

        return $this->$action($myRequest);
    }

    public function acceptDoctorRequest(MyRequest $myRequest)
    {
        try {
            $newRequest = new Request();
            $newRequest->merge(['id' => $myRequest->project_id]);
            $project = $this->projectRepository->search($newRequest)->first();
            $project->update(['lastStatus' => 'approved']);
            $this->assignApprovedTeamToProject($myRequest);
            $myRequest->update(['status' => 'approved']);
            // dd($myRequest);
            return true;
        } catch (Exception $e) {

            return  false;
        }
    }

    public function acceptStudentRequest(MyRequest $myRequest)
    {

        $newRequest  = new Request();
        $newRequest->merge(['created_by' => $myRequest->request_to]);

        if ($this->checkIfStudentLeader($newRequest)) {

            return  sendError('You Are team Leader', 'You Are Team leader');
        }

        $requestForLeaderId = new Request();
        $requestForLeaderId = $requestForLeaderId->merge(['id' => $myRequest->request_to]);
        $flagForAdmin = new Request();
        $flagForAdmin = $flagForAdmin->merge(['id' => $myRequest->created_by]);

        try {
            DB::transaction(function () use ($myRequest, $requestForLeaderId, $flagForAdmin) {
                $accepted =  $this->studentRepository->search($requestForLeaderId)->first();
                $accepted ->update(["leader_id" => $myRequest->created_by]);

                $this->studentRepository->search($flagForAdmin)->first()
                ->update(["isleader" => 1]);
               $myrequests =  MyRequest::query()->where('created_by',$accepted->id)->get();
                foreach( $myrequests as $myrequest) {
                    $myrequest->delete();
                }

                // dd($myRequest);
                $myRequest->update(['status' => 'approved']);
            });
            DB::commit();
            return  true;
        } catch (Exception $e) {
            DB::rollBack();
            return  false;
        }
    }
}
