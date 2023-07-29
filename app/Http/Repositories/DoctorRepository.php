<?php

namespace App\Http\Repositories;

use App\Models\Doctor;
use App\Models\ProjectDoctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorRepository
{
    public function search(Request $request)
    {
        $doctor = Doctor::with(['projects' => function ($q) {
            $q->select('name', 'description');
        }]);

        if ($request->filled('id')) {

            $doctor->where('id', $request->id);
        }

        return $doctor;
    }
    public function fill(Request $request)
    {
        if (!isset($doctor)) {

            $doctor = new Doctor();
        }

        $doctor->name = $request->name;
        $doctor->email = $request->email;
        $doctor->password = Hash::make($request->password);
        if ($request->filled('status')) {
            $doctor->status = $request->status;
        }
        $doctor->save();

        $doctor->token = $doctor->createToken($doctor->email)->plainTextToken;

        return $doctor;
    }

    public function acvtivation(Request $request, ?Doctor $doctor = null)
    {

        if ($request->filled('status')) {
            $doctor->status = $request->status;
        }

       return $doctor->save();

    }

    public function assignDoctor(Request $request)
    {
        $projectDoctor = new ProjectDoctor();
        $projectDoctor->project_id = $request->project_id;
        $projectDoctor->doctor_id = $request->doctor_id;
        $projectDoctor->type = $request->type;

        return $projectDoctor->save();
    }

    public function deleteDoctor(Request $request, Doctor $doctot)
    {
        return $doctot->delete();
    }
}
