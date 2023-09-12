<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required|string|max:100|regex:/^[a-zA-Z]+$/',
            'lastname' => 'required|string|max:100|regex:/^[a-zA-Z]+$/',
            'phone' => 'nullable|regex:/^\+212\s[67]\d{8}$/|'.Rule::unique(User::class)->ignore($this->user()->id),
            'dob' => 'nullable|date|before:18 years ago',
            'email' => 'required|string|email|max:255|',Rule::unique(User::class)->ignore($this->user()->id),
            'job_title' => 'nullable|string|max:100',
            'avatar' => 'mimes:png,jpg,jpeg|max:1024',
            ];
    }
}
