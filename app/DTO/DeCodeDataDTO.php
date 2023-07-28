<?php

namespace App\DTO;

use Fresns\DTO\DTO;

class DeCodeDataDTO extends DTO
{
    public function rules(): array
    {
        return [
            'code' => 'required|string', // code 字段必须存在且为字符串
            'activation_device' => 'required|string', // 设备字段必须存在且为字符串
            'activation_ip' => 'required|ip', // IP 字段必须存在且为有效 IP 地址
            'activation_app_signature' => 'required|string', // 项目签名字段必须存在且为字符串
            'timestamp' => 'required|string'//时间戳
        ];
    }
}
