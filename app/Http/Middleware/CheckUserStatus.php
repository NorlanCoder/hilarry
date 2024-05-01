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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()) {
            if ($request->user()->role !== 'admin') {
                return response()->json([
                    'status' => true,
                    'message' => "Vous n'avez pas les droits neccesaire pour cette action",
                ], 200);
            }
    
            return $next($request);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Connectez vous d'abord pour effectuer cette action",
            ], 200);
        }
        
                
    }
}
