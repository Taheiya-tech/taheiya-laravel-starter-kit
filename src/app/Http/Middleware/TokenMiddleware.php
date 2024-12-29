<?php

namespace TaheiyaTech\TaheiyaLaravelStarterKit\App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->headers->set('Accept', 'application/json');
        if(!$request->headers->has('Authorization')){
            throw new AuthenticationException("Token is missing");
        }
        $getHeader = $request->header('Authorization');
        $token = Str::after($getHeader, 'Bearer ');
        if (!Cache::has($token)) {
            throw new AuthenticationException("Token is invalid");
        }
        $user = json_decode(Cache::get($token));
        app()->instance('userData', $user);
        try {
            app()->instance('apiKey', $this->getApiKey($user));
        } catch (\Throwable $th) {
            throw new AuthenticationException($th->getMessage());
        }

        return $next($request);
    }


    public function getApiKey($user)
    {
        if(!Cache::has('company.'. $user->company_id . '.'. env('PLATFORM_ID')))
        {
            throw new AuthenticationException("User Cannot access this platform");
        }
        return Cache::get('company.'. $user->company_id . '.'. env('PLATFORM_ID'));
    }
}
