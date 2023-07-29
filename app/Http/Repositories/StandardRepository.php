<?php

namespace App\Http\Repositories;


use App\Models\Doctor;
use App\Models\Note;
use App\Models\Standard;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StandardRepository
{
    public function search(Request $request)
    {
        $standard = Standard::query();

        if ($request->filled('standard_type')) {
            $standard->where('standardType', $request->standard_type);
        }
        return $standard;
    }

    public function fill(Request $request, ?Standard $standard = null)
    {
        if (!isset($standard)) {
            $standard = new Standard();
        }
        try {
            $standard->name=$request->name;
            $standard->standardType=$request->standardType;
            $standard->maxMark=$request->max_mark;

           return $standard->save();

        } catch (Exception $e) {

            return $e;
        }


    }
    public function storeNotes(Request $request, ?Note $note = null)
    {
        if (!isset($note)) {
            $note = new Note();
        }
        try {
            $note->content=$request->content;
            $note->type=$request->type;

           return $note->save();

        } catch (Exception $e) {

            return $e;
        }


    }

    public function getNotes(Request $request, ?Note $note = null)
    {
      $note = Note::query();
       if($request->filled('type')) {
            $note->where('type',$request->type);
       }

       return $note;

    }

    public function deleteStandard(Request $request,Standard $standard)
    {
       return $standard->delete();
    }
}
