<?php


namespace app\Requests\Users;
use App\Requests\BaseRequestFormApi;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'email'=>'required|string|email|exists:users',
            'password'=>'required|min:8'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'The email is required.',
            'email.exists' => 'The email is not valid',
            'password.required' => 'The password is required.',
        ];
    }
}