<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MyRequest extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'myrequests';

    public function Student()
    {
        return $this->belongsTo(Student::class,'created_by');
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id');
    }
}
