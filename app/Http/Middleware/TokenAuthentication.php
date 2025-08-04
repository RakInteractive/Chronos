<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenAuthentication {
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response {
        if (!$request->has('token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = Token::where('token', $request->input('token'))->first();

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
