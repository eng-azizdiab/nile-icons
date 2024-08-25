<?php


namespace app\Requests\Users;
use App\Requests\BaseRequestFormApi;

class LoginUserRequest extends BaseRequestFormApi
{

    public function rules(): array
    {
        return [

            'email'=>'required|string|email',
            'password'=>'required|min:8'
        ];
    }
    public function authorized(): bool
    {
        return true;
    }
}
