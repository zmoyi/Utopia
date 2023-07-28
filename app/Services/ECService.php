<?php

namespace App\Services;

use phpseclib3\Crypt\EC;

class ECService
{

    /**
     * 生成公钥密钥Base64
     * @return array
     */
    public function getEcKey(): array
    {
        $privateKey = EC::createKey('NISTP256');

        $publicKey = $privateKey->getPublicKey();
        return [
            'publicKey' => base64_encode($publicKey),
            'privateKey' => base64_encode($privateKey)
        ];
    }

    /**
     * 获取ECBase解密
     * @param string $key
     * @return bool|string
     */
    public function getEcBaseDecode(string $key): bool|string
    {
        return base64_decode($key);
    }

    /**
     * 用户调用接口生成签名
     * 生成签名
     * @param array $data
     * @param string $privateKey
     * @return string
     */
    public function generateSignature(array $data, string $privateKey): string
    {
        $enData = base64_encode(json_encode($data));
        $privateKey = $this->getEcBaseDecode($privateKey);
        $key = EC::loadPrivateKey($privateKey);
        return $key->sign($enData);
    }

    /**
     * 用户发起接口进行签名请求认证
     * 验证签名
     * @param array $data
     * @param string $signature
     * @param string $publicKey
     * @return mixed
     */
    public function verifySignature(array $data, string $signature, string $publicKey): mixed
    {
        $enData = base64_encode(json_encode($data));
        $publicKey = $this->getEcBaseDecode($publicKey);
        $key = EC::loadPublicKey($publicKey);
        return $key->verify($enData,base64_decode($signature));

    }


}
