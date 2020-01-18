<?php

namespace App\Http\Controllers;
use App\Jobs\UserEmailVerification;
use App\Models\User;
use App\Token\Token;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class UserController extends Controller
{
    use AuthenticatesUsers;


    public function index(User $user){

        return response()->json([
           'users' => $user::paginate(4)
        ]);
    }


    public function login(Request $request)
    {
        $this->validateLogin($request);
        if ($this->attemptLogin($request)) {
            //user logged in
            $token = Token::GenerateToken($this->guard()->user());
            if($token==null)
            {
                return response()->json(['error'=>'failed to login'],422);
            }
            return response()->json(['message'=>'user logged in',
                'token' =>  Token::GenerateToken($this->guard()->user())]) ;
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    public function sendFailedLoginResponse(Request $request)
    {
        return response()->json(['error'=>'failed to login the user'],422);
    }

        public function SignUp(Request $request,User $user){

//in case of being not valid a response of 422 will be sent
            $validated=$request->validate([
                'Name' => 'required',
                'Email' => 'required|email|unique:users,email',
                'Password' => 'required',
            ]);

         if($validated){
             //agreed to the terms and condition
             if ($request->Terms == null) {
                 return response()->json(['error' => 'You must be agreed to the Terms'], 422);
             }
             //data verified
             $user->name = $request->Name;
             $user->email = $request->Email;
             $user->password = Hash::make($request->Password);
             $user->api_token=Str::random(80);
             $user->is_admin = false;
             if ($user->save()) {
                 dispatch((new UserEmailVerification($user->email))->delay(now()->addSeconds(10)));
                 //account has been created successfully with success code of 200
                 return response()->json(['message' => 'Your Account has been created successfully',
                     'token' => Token::GenerateToken($user)], 200);
             } else {
                 return response()->json(['error' => 'failed to created account'], 422);
             }
         }else{
             return response()->json(['error'=>$validated],422);
         }
        }


        public function verifyUser(Request $request)
        {
            if($request->token)
            {
                if(Token::VerifyUser($request->input('token')) != null)
                {
                    return response()->json(['auth'=>true],200);
                }else{
                    return response()->json(['auth'=>false],422);
                }
            }
        }

        public  function admin(Request $request)
        {
            if(Token::AdminUser($request->input('token'))){
                return response()->json(['admin',true],200);
            }else{
                return response()->json(['admin',false],200);
            }
        }

}
