<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'project_id' =>'required|unique:doctors',
            'created_by' =>'required',
            'request_to' =>'required',
            'type' =>'required',

        ];
    }
}
