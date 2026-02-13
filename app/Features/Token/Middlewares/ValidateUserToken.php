<?php

declare(strict_types=1);

namespace App\Features\Token\Middlewares;

use App\Features\Token\Models\Token;
use Closure;
use Illuminate\Http\Request;

class ValidateUserToken
{
    public function handle(Request $request, Closure $next): mixed
    {
        $token = $request->bearerToken(); // Get token from Authorization: Bearer <token>

        if (! $token) {
            return response()->json(['error' => 'No token provided'], 401);
        }

        $token = Token::where('token', $token)
            ->first();

        if ($token === null) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        return $next($request);
    }
}
