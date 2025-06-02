<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        
        $token = $request->header("Authorization");
        $user = User::where('remember_token', $token)->first();
        if(!$user) {
            return response()->json([
                "errors" => [
                    "message" => ["Unauthorized, Pengguna tidak ditemukan"]
                ]
            ]);
        }
        Auth::login($user);
        return $next($request);

    }
}
