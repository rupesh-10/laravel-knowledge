<?php

namespace App\Http\Middleware;

use App\Models\Invitation;
use Closure;
use Illuminate\Http\Request;

class VerificationMiddleware
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
        if (!$request->has('verification_code')) {
            return response()->json(['message'=>'Verification Code not found']);
        }
        $code = $request->get('verification_code');
        $invitation = Invitation::where('verification_code',$code)->where('email',$request->get('email'))->where('expires_at','>',now())->first();
        if (!$invitation)
        {
            return response()->json(['message'=>'Sorry, Link not found!']);
        }
        return $next($request);
    }
}
