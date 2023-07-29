<?php

namespace App\Http\Controllers\api\doctor\auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\DoctorRepository;
use App\Http\Requests\CreateDoctorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Validators;

class DoctorAuthController extends Controller
{
    public function __construct(private DoctorRepository $doctorRepository)
    {}
    public function register(Request $request)
    {
        $rules = new CreateDoctorRequest();
        $validator = \Validator::make($request->all(), $rules->rules());

        if($validator->fails() ){
            return sendError('Validation Error.', $validator->errors());
        }
        $doctor = $this->doctorRepository->fill($request);

        return  sendResponse($doctor, 'doctor Successfully Created');
    }

    public function login(Request $request)
    {
        if(Auth::guard('doctor')->attempt(['email' => $request->email, 'password' => $request->password ])) {
            $doctor = Auth::guard('doctor')->user();
            if($doctor->status == 'active') {

                $success['token'] =  $doctor->createToken($request->email)->plainTextToken;
                $success['email'] =  $doctor->email;
                $success['id'] =  $doctor->id;

                return sendResponse($success, 'User login successfully.');
            }
            return sendResponse('inActive', 'User login Failed');

        }
        else{
            return sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }
}
