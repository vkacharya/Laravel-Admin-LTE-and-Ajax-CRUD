<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StreamStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            "student_id" => 'required',
            "stream_type" => 'required',
            "is_active" => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'student_id.required' => 'student ID is Required',
            'stream_type' => 'Please Select Stream Type',
            'is_active' => 'Please Select Student Active Status',
        ];
    }
}
