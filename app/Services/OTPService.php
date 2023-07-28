<?php

namespace App\Services;

use Exception;
use Hashids\Hashids;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use OTPHP\TOTP;


class OTPService
{

    /**
     * 创建TOTP
     * @return string
     */
    public function generateTOTP(): string
    {
        $otp = TOTP::generate();
        $otp->setDigits(8);
        $otp->setPeriod(10);
        $otp->setDigest(hash_algos()[5]);
        $otp->at(Carbon::now()->timestamp);
        $now = $otp->now();
        Cache::add($now, $otp->getSecret());
        return $now;
    }

    /**
     * 验证TOTP
     * @param string $otp
     * @return bool
     * @throws Exception
     */
    public function verifyTOTP(string $otp): bool
    {
        $secret = Cache::pull($otp);
        if (empty($secret)){
            throw new Exception('令牌错误', 100);
        }
        $totp = TOTP::createFromSecret($secret);
        $totp->setDigits(8);
        $totp->setPeriod(10);
        $totp->setDigest(hash_algos()[5]);
        return $totp->verify($otp, Carbon::now()->timestamp);
    }
}
