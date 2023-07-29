<?php

namespace App\Http\Controllers\api\grades;
use App\Http\Controllers\Controller;
use App\Http\Repositories\GradeRepository;

use Illuminate\Http\Request;

class gradeController extends Controller
{
    public function __construct(private GradeRepository $gradeRepository)
    {
    }

    public function store(Request $request)
    {
        if($this->gradeRepository->fill($request) != true) {
            sendError($this->gradeRepository->fill($request), 'something is Wrong');
        }

        sendResponse('grade Created Successfully', 'grade Created Successfully');

    }
}
