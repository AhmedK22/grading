<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Team;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    public function team()
    {
        return $this->belongsToMany(Team::class , 'students_teams','student_id','team_id');
    }

    public function project()
    {
        return $this->belongsTo(project::class,'project_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class , 'grades');
    }


}
