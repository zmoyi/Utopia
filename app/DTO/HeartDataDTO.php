<?php

namespace App\DTO;

use Fresns\DTO\DTO;

class HeartDataDTO extends DTO
{
    public function rules(): array
    {
        return [
            'code' => 'required', // 卡密必填
            'token' => 'required|string', // 必填，且为32位的MD5字符串
            'timestamp' => 'required|integer|min:1', // Timestamp is required and must be a positive integer
        ];
    }
}
