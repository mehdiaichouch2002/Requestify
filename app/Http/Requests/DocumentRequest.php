<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required',
            'title' => 'required',
            'description' => 'required',
            'attached_files' => 'array',
            'attached_files.*' => 'file|mimes:pdf,doc,rtf,docx,jpeg,png,jpg|max:2048',
            ];
    }
}
