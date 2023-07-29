<?php

namespace App\Http\Repositories;

use App\Models\MyRequest;
use App\Models\Project;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentRepository
{
    public function search(Request $request)
    {
        $student = Student::query();

        if($request->filled('id')) {

            $student->where('id',$request->id);
        }

        if($request->filled('project_id')) {
            $student->where('id',$request->project_id);
        }

        return $student;
    }
    public function fill(Request $request)
    {
        $student = new Student();

        $student->name = $request->name;
        $student->level = $request->level;
        $student->program = $request->program;
        $student->email = $request->email;
        $student->password = Hash::make($request->password);
        $student->sitting_no = $request->sitting_no;
        $student->save();
        $student->token = $student->createToken('MyApp')->plainTextToken;
        return $student;
    }

    public function getStudentProject(Request $request)
    {
        $projects = Project::where('id',$request->id);

        return $projects;
    }

    public function getStudentsOfProject(Request $request)
    {
        $students = Student::where('project_id', $request->project_id);

        return $students;
    }

}
