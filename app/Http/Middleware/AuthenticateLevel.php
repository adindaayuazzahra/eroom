<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $aksesLevel)
    {
        if (!Auth::check()){
            return redirect()->route('home.login')->with('error',"Error: Harap login dahulu");
        }
        
        $user = Auth::user();
        if($user->akses_level == $aksesLevel){
            return $next($request);
        }
        return abort(401, 'Level akses tidak sesuai');
    }
}
