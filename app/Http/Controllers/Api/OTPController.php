<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OTPService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OTPController extends Controller
{
    protected OTPService $OTP;
    public function __construct(OTPService $service)
    {
        $this->OTP = $service;
    }

    public function getToken(): JsonResponse
    {
        return response()->json([
            'token' =>  $this->OTP->generateTOTP()
        ]);
    }
}
