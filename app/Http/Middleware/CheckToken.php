<?php

namespace App\Http\Middleware;

use App\Services\OTPService;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!$request->hasHeader('X-Auth-OTP-Token') || empty($request->header('X-Auth-OTP-Token'))) {
            return response()->json(['message' => '请携带令牌'], 401);
        } elseif (!(new OTPService())->verifyTOTP($request->header('X-Auth-OTP-Token'))) {
            return response()->json(['message' => '令牌无效'], 401);
        }
        return $next($request);
    }
}
