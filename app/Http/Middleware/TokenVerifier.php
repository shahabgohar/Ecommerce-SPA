<?php
namespace App\Http\Middleware;
use App\Token\Token;
use Closure;
use Illuminate\Http\Request;

class TokenVerifier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->input('token'))
        {
            if($request->input('token')==null)
            {
                return response()->json(['error'=>'no token'],422);
            }
            Token::AuthenticateToken($request->input('token'));
                return $next($request);
        }else{
            return response()->json(['error'=>'no token'],422);
        }

    }
}
