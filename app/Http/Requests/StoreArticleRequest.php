<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'visible' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'sub_articles' => 'nullable|array',
            'sub_articles.*.title' => 'required|string|max:255',
            'sub_articles.*.description' => 'required|string',
            'sub_articles.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sub_articles.*.image_position' => 'required|string|max:5',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title is required.',
            'description.required' => 'The description is required.',
            'image.file' => 'The image must be a valid file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'visible.required' => 'The visibility status is required.',
            'category_id.required' => 'The category ID is required.',
            'category_id.exists' => 'The selected category does not exist.',
        ];
    }
}
