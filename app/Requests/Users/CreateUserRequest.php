<?php


namespace app\Requests\Users;
use App\Requests\BaseRequestFormApi;

class CreateUserRequest extends BaseRequestFormApi
{

    public function rules(): array
    {
        return [
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8'
        ];
    }
    public function authorized(): bool
    {
        return true;
    }
}
