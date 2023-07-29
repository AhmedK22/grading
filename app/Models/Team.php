<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Team extends Model
{
    use HasFactory;
    public function student()
    {
        return $this->belongsToMany(Student::class , 'students_teams','team_id','student_id');
    }
}
