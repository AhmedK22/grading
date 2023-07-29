<?php

namespace App\Http\Controllers\api\student\auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\StudentRepository;
use App\Http\Requests\CreateStudentRequest;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAuthController extends Controller
{
    public function __construct(private StudentRepository $studentRepository)
    {}
    public function register(Request $request)
    {
        $rules = new CreateStudentRequest();
        $validator = \Validator::make($request->all(), $rules->rules());

        if($validator->fails() ){
            return sendError('Validation Error.', $validator->errors());
        }
        $student = $this->studentRepository->fill($request);

        return  sendResponse($student, 'Student Successfully Created');
    }

    public function login(Request $request)
    {
        if(Auth::guard('student')->attempt(['email' => $request->email, 'password' => $request->password ])) {
            $student = Auth::guard('student')->user();
            $success['token'] =  $student->createToken($request->email)->plainTextToken;
            $success['email'] =  $student->email;
            $success['name'] =  $student->name;
            $success['id'] =  $student->id;

            return sendResponse($success, 'User login successfully.');
        }
        else{
            return sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }
}
