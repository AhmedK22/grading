<?php

namespace App\Http\Controllers\api\student;

use App\Http\Controllers\Controller;
use App\Http\Repositories\RequestRepository;
use App\Http\Repositories\StudentRepository;
use App\Http\Services\RequestService;
use Exception;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct(public StudentRepository $studentRepository
     ,public RequestRepository $requestRepository,
     public RequestService $requestService)
    {
    }

    public function index(Request $request)
    {
        $students = $this->studentRepository->search(new Request)->get();
        return sendResponse($students,'allSTudents');
    }
    public function createTeam(Request $request)
    {
        return $this->requestService->createRequest($request);
    }

    public function createDoctorRequest(Request $request)
    {
       return $this->requestService->createRequest($request);
    }
    public function getStudentRequest(Request $request)
    {

        try{
            $data = $this->requestRepository->getRequest($request)->get();

            return sendResponse($data, 'All Request You Have');
        }catch (Exception $e) {

            return sendError($e, 'Something Is Wrong');

        }

    }

    public function acceptStudentRequest(Request $request,$request_id)
    {

        $data = $this->requestService->acceptRequest($request,$request_id);
        if(! $data) {

         return sendError('something is wrong', 'something is wrong');
        }

        return sendResponse('Requst Has Been Accepted ', 'Requst Has Been Accepted  ');
    }

    public function getProjectOfStudent(Request $request)
    {

       $project =  $this->studentRepository->getStudentProject($request)->get();
       return sendResponse($project, 'Project You Select');

    }

    public function getStudentsOfProject(Request $request)
    {
        $students =  $this->studentRepository->getStudentsOfProject($request)->get();

        return sendResponse($students, 'student of project');
    }

}
