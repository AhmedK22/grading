<?php

namespace App\Http\Repositories;

use App\Models\Grade;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GradeRepository
{
    public function search(Request $request, ?Grade $project = null)
    {
        if ($request->type=='admin') {
            // dd($request);
            return $this->gradesForAdmin($request);
        } else  if ($request->type=='doctor') {
            return $this->gradesForDoctor($request);
        } else  if ($request->type=='student') {
            return $this->gradeForStudent($request);
        }
    }

    public function gradesForAdmin(Request $request, ?Grade $project = null)
    {
        $grade = Student::select('students.id', 'students.name', DB::raw('SUM(grades.mark) / COUNT(DISTINCT grades.doctor_id) as average'))
        ->join('grades', 'students.id', '=', 'grades.student_id')
        ->where('students.project_id', $request->project_id)
        ->groupBy('students.name', 'students.id');

        return $grade;
    }

    public function gradesForDoctor(Request $request, ?Grade $project = null)
    {
        $grade = Student::select('students.id', 'students.name', DB::raw('SUM(grades.mark) / COUNT(DISTINCT grades.doctor_id) as average'))
        ->join('grades', 'students.id', '=', 'grades.student_id')
        ->where('grades.doctor_id', $request->doctor_id)
        ->groupBy('students.name', 'students.id');


        return $grade;
    }

    public function gradeForStudent(Request $request, ?Grade $project = null)
    {


        $grade = Student::select('students.id', 'students.name', DB::raw('SUM(grades.mark) / COUNT(DISTINCT grades.doctor_id) as average'))
        ->join('grades', 'students.id', '=', 'grades.student_id')
        ->where('students.id', $request->student_id)
        ->groupBy('students.name', 'students.id');

        return $grade ;
    }



    public function fill(Request $request, ?Grade $project = null)
    {
        if (!isset($grade)) {
            $grade = new Grade();
        }
        try {
            $grade->doctor_id = $request->doctor_id;
            $grade->student_id = $request->student_id;
            $grade->standard_id = $request->standard_id;
            $grade->mark = $request->mark;

            return  $grade->save();
        } catch (Exception $e) {

            return $e;
        }
    }
}
