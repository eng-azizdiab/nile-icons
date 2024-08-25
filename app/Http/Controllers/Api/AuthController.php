<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use app\Requests\Users\ChangePasswordRequest;
use app\Requests\Users\CreateUserRequest;
use app\Requests\Users\LoginUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    //ReflectionException: Class "app\Requests\Users\CreateUserRequest" does not exist in file C:\Aziz\projects\Laravel Projects\nile-icons\vendor\laravel\framework\src\Illuminate\Routing\ResolvesRouteDependencies.php on line 81
    public $userService;
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    public function register(CreateUserRequest $createUserRequest){
        if (\auth()->user()->role==='admin'){
        if (!empty($createUserRequest->getErrors())){
            return response()->json(['error' => $createUserRequest->getErrors()], 406);

        }
        $user=$this->userService->createUser($createUserRequest->request()->all());
        $message['user']=$user;
        $message['token']=$user->createToken('MyApp')->plainTextToken;
       return $this->sendResponse($message,'success');}
        else{
            $message['data']='unauthorised';
            return $this->sendResponse($message,'failed');
        }
    }

    public function change_password(ChangePasswordRequest $changePasswordRequest){
        $validated = $changePasswordRequest->validated();

        $email = $changePasswordRequest->input('email');
        $password = $changePasswordRequest->input('password');
        $user=User::where('email',$email)->first();;
        $password = Hash::make($password);
        $user->update(['password' => $password]);
        $message['user']=$user;
        $message['token']=$user->createToken('MyApp')->plainTextToken;
        return $this->sendResponse($message,'success');
    }

    public function login(LoginUserRequest $loginUserRequest){
        if (!empty($loginUserRequest->getErrors())){
            return response()->json(['error' => $loginUserRequest->getErrors()], 406);

        }
        $request=$loginUserRequest->request();
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['user'] = $user;
            return $this->sendResponse($success, 'User logged in successfully');
        }else{
            return $this->sendResponse('unauthorised', 'fail',401);
        }

    }


    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json([
            "message"=>"logged out"
        ]);
    }

    public function all_admins(){
       if (\auth()->user()->role==='admin'){
           $users=User::all();
          $message['users']=$users;
           return $this->sendResponse($message,'success');
       }else{
           $message['data']='unauthorised';
           return $this->sendResponse($message,'failed');
       }
    }
    public function delete_user($id){

        if (\auth()->user()->role==='admin'){
           $user=User::find($id);
           $user->delete();
           return response()->json([
               "message"=>"deleted successfully"
           ]);
       }else{
           $message['data']='unauthorised';
           return $this->sendResponse($message,'failed');
       }


    }
}
