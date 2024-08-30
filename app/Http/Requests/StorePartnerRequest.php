<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePartnerRequest extends FormRequest
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
            'partners' => 'required|array',
            'partners.*.name' => 'required|string|max:255',
            'partners.*.image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}