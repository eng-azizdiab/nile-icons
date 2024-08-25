<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'notes' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name is required.',
            'phone.required' => 'The phone is required.',
            'notes.required' => 'The notes is required.',
            'email.required' => 'The email is required.',
        ];
    }
}
