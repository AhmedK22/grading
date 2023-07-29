<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
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
            'name'=>['required','max:15','string'],
            'project-type'=>['required','string'],
            'objectives'=>['required','string'],
            'description'=>['required','string'],
            'status'=>['required'],
            'skills'=>['required'],
            'max-mark'=>['required','integer'],
           'number-of-student'=>['required','integer'],
           'date-of-exam'=>['required','date'],
        ];
    }
}
