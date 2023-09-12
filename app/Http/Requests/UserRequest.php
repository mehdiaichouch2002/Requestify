<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'firstname' => 'required|string|max:100|regex:/^[a-zA-Z]+$/',
            'lastname' => 'required|string|max:100|regex:/^[a-zA-Z]+$/',
            'phone' => 'nullable|regex:/^\+212\s[67]\d{8}$/|'.Rule::unique(User::class)->ignore($this->id),
            'sexe' => 'nullable|string|in:male,female',
            'dob' => 'nullable|date|before:18 years ago',
            'role' => 'string|in:admin,collaborator',
            'email' => 'required|string|email|max:255|'.Rule::unique(User::class)->ignore($this->id),
            'job_title' => 'nullable|string|max:100',
            'avatar' => 'mimes:png,jpg,jpeg|max:1024',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
    public function messages()
    {
        return [
            'firstname.regex' => 'The :attribute field should only contain alphabetic characters.',
            'lastname.regex' => 'The :attribute field should only contain alphabetic characters.',
            'dob.before' => 'You must be at least 18 years old.',
        ];
    }
}
