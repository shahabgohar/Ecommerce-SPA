<?php

namespace App\Http\Controllers;

use App\Jobs\SendPasswordResetLink;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Mockery\Generator\StringManipulation\Pass\Pass;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function validateEmail(Request $request){
        $validate = Validator::make($request->all(),[
            'email' => 'required|email|exists:users,email'
        ]);
        if($validate->fails())
            return false;
        else
            return true;

    }

    public function sendResetLinkEmail(Request $request)
    {
        if ($this->validateEmail($request)) {
            $user = User::where('email',$request->email)->first();

            dispatch((new SendPasswordResetLink($user->id))->delay(Carbon::now()->addSeconds(10)));
            $response = Password::RESET_LINK_SENT;
            $response == Password::RESET_LINK_SENT
                ? $this->sendResetLinkResponse($request, $response)
                : $this->sendResetLinkFailedResponse($request, $response);
            return response()->json($response);
        }

    }
    public function sendResetLink($object){

    }
}
