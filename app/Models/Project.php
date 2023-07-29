<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
  protected $fillable  = ['lastStatus'];
    public function student()
    {
        return $this->belongsToMany(student::class,'student_id');
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class)->withPivot('type');
    }

    public function setSkillsAttribute($value)
    {
        $this->attributes['skills'] =json_encode($value);
    }

    public function setSupervisorAttribute($value)
    {
        $this->attributes['supervisor'] =json_encode($value);
    }

}
