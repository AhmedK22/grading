<?php

namespace App\Http\Controllers\api\doctor;

use App\Http\Controllers\Controller;
use App\Http\Repositories\DoctorRepository;
use App\Http\Repositories\GradeRepository;
use App\Http\Repositories\RequestRepository;
use App\Http\Services\RequestService;
use App\Models\Doctor;
use Exception;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct(private DoctorRepository $doctorRepository, private RequestRepository  $requestRepository
    ,
    private RequestService $requestService
    ,private GradeRepository $gradeRepository)
    {
    }

    public function index(Request $request)
    {

        try {
            $doctors = $this->doctorRepository->search($request)->get();

            return sendResponse($doctors, 'Doctors retrieved successfully.');
        } catch (Exception $e) {
            return sendError('Bad Request', $e);
        }
    }

    public function getDoctorRequest(Request $request)
    {
        try{
            $data = $this->requestRepository->getRequest($request)->get();

            return sendResponse($data, 'All Request Doctor Have');
        }catch (Exception $e) {

            return sendError($e, 'Something Is Wrong');

        }

    }

    public function acceptRequest(Request $request, $request_id)
    {
        $data = $this->requestService->acceptRequest($request, $request_id);
        if (!$data) {

            return sendError('something is wrong', 'something is wrong');
        }

        return sendResponse($data, 'requests have been accept');
    }

    public function assignDoctor(Request $request)
    {
        try {
            if( $this->doctorRepository->assignDoctor($request)) {

                return sendResponse( 'doctor has been assigned', 'doctor has been assigned');
               }

        } catch (Exception $e) {
            return sendError('some thing is wrong', $e);
        }


    }

    public function destroy(Request $request)
    {
        $doctorModel =  $this->doctorRepository->search($request)->first();
       if(  $doctorModel != null) {

           if ($this->doctorRepository->deleteDoctor($request, $doctorModel) != true) {

               sendError('something is Wrong', 'something is Wrong');
           }
           return sendResponse('doctor deleted', 'doctor deleted Successfully');
       }
       return  sendError('this doctor not exist', 'this doctor not exist');


    }

    public function changeActivity(Request $request, $doctor)
    {
        $doctorModel = Doctor::find($doctor);
        if ($this->doctorRepository->acvtivation($request, $doctorModel) != true) {

            return sendError('something is Wrong', 'something is Wrong');
        }

        return sendResponse('doctor activaty changed', 'doctor activaty changed');
    }

    public function insertGrades(Request $request)
    {
        if(! $this->gradeRepository->fill($request)) {
            return sendError('something is Wrong', 'something is Wrong');
        }
        return sendResponse('grade inserted successfully', 'grade inserted successfully');

    }
    public function getGrades(Request $request)
    {
        $grades = $this->gradeRepository->search($request)->get();

        return sendResponse( $grades, 'all grades');

    }

}
