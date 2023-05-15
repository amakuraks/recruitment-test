<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $user = $request->user();

        if($user && !$user->is_active ){
            if(Auth::user()){
                Auth::guard('web')->logout();
            }

            $acceptHeader = request()->header('Accept');
            if (strpos($acceptHeader, 'application/json') !== false) {
                // API request
                return response()->json(['error' => 'user is disabled'], 403);
            } else {
                // Web request
                return redirect()->route('login');
            }
        }
        return $next($request);
    }

}
