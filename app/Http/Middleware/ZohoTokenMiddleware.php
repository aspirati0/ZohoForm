<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\ZohoTokenService;

class ZohoTokenMiddleware
{
    protected $tokenService;

    public function __construct(ZohoTokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

   public function handle($request, Closure $next)
{
    if ($request->isMethod('post') && $request->is('zoho')) {
        $accessToken = $this->tokenService->refreshAccessToken();
    } else {
        $accessToken = $this->tokenService->getAccessToken();
    }

    $request->headers->set('Authorization', 'Bearer ' . $accessToken);

    return $next($request);
}
}