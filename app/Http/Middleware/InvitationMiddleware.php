<?php

namespace App\Http\Middleware;

use App\Models\Invitation;
use Closure;
use Illuminate\Http\Request;

class InvitationMiddleware
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
        if (!$request->has('invitation_token')) {
            return response()->json(['message'=>'Token doesnot exists']);
        }
        $token = $request->get('invitation_token');
        try {
            $invitation = Invitation::where('invitation_token', $token)->where('expires_at','>',now())->firstOrFail();
        } catch (\Throwable $e) {
            return response()->json(['message'=>'Sorry, The invitation link is expired. Please try new.']);
        }
        if (!is_null($invitation->registered_at)) {
            return response()->json(['message'=>'It is already used']);
        }
        return $next($request);
    }
}
