<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
            "name" => 'required',
            "image" => 'required|image|mimes:png,jpg,jpeg',
            "address" => 'required',
            "contact" => 'required',
            "documents" => 'required',
            "documents.*" => 'mimes:pdf',
        ];
    }

    public function messages(): array
    {
        return [
            "documents.required" => "You must upload at least one file",

        ];
    }
}
