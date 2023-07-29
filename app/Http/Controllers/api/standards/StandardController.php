<?php

namespace App\Http\Controllers\api\standards;

use App\Http\Controllers\Controller;
use App\Http\Repositories\StandardRepository;
use App\Http\Requests\CreateStandardRequest;
use App\Models\Standard;
use Illuminate\Http\Request;

class StandardController extends Controller
{
    public function __construct(public StandardRepository $standardRepository)
    {
    }
    public function index(Request $request)
    {
       $standards = $this->standardRepository->search($request)->get();

       return sendResponse($standards, 'All Standards') ;

    }


    public function store(CreateStandardRequest $request)
    {

        if($this->standardRepository->fill($request) != true) {

         return  sendError('something is Wrong', 'something is Wrong');
        }

        return sendResponse('Standard Created Successfully', 'Standard Created Successfully');
    }

    public function update(Request $request, $standard)
    {
        $standardModel = Standard::find($standard);
        if($standardModel != null) {

            if ($this->standardRepository->fill($request, $standardModel) != true) {
                return sendError($this->standardRepository->fill($request), 'something is Wrong');
            }

            return sendResponse('standard Updated Successfully', 'standard Updated Successfully');
        }
        return sendError('standard not exist', 'standard not exist');

    }

    public function destroy(Request $request, $standard)
    {
        $standardModel = Standard::find($standard);
       if(  $standardModel != null) {

           if ($this->standardRepository->deleteStandard($request, $standardModel) != true) {
               sendError('something is Wrong', 'something is Wrong');
           }
           return sendResponse('standard deleted', 'standard deleted Successfully');
       }
       return  sendError('this standard not exist', 'this standard not exist');


    }

    public function insertNotes(Request $request )
    {
        if($this->standardRepository->storeNotes($request) != true) {

            return  sendError('something is Wrong', 'something is Wrong');
           }

           return sendResponse('Notes Created Successfully', 'Notes Created Successfully');
    }
    public function getNotes(Request $request )
    {
       $notes = $this->standardRepository->getNotes($request)->get();

        return sendResponse($notes, 'All Notes Returned Successfully');
    }

}
