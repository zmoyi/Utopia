<?php

namespace App\Services\Api;

use App\DTO\DeCodeDataDTO;
use App\DTO\HeartDataDTO;
use App\Models\CardCodes;
use App\Services\ECService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use ParagonIE\ConstantTime\Base64;
use Throwable;

class CardCodesService
{
    protected ECService $EC;

    const HEART = 1;
    const VERIFY = 0;

    public function __construct(ECService $EC)
    {
        $this->EC = $EC;
    }

    /**
     * 激活卡密
     * @param array $data
     * @return array
     * @throws Throwable
     */
    public function ActivateCardCode(array $data): array
    {
        list($deCodeData, $cardCode, $app) = $this->decrypt(self::VERIFY, $data);
        /**
         * 判断卡密次数
         */
        if ($cardCode->usage_limit === 1) {
            // 卡密只能激活一次，激活后设置为 0
            $cardCode->update([
                'is_used' => true,
                'usage_limit' => 0,
                'active' => true
            ]);
            $activationCount = 1;
        } else if ($cardCode->usage_limit > 1) {
            // 卡密可以多次激活，每次激活将递减一个值
            $usageLimit = max(0, $cardCode->usage_limit - 1);
            $cardCode->update([
                'is_used' => true,
                'usage_limit' => $usageLimit,
                'active' => true
            ]);
            $activationCount = $cardCode->activation_count + 1;
        } else {
            // 卡密已失效，抛出异常
            throw new Exception('该卡密已失效，无法再次激活！');
        }

        $this->addCodeList($cardCode, [
            'activation_ip' => $deCodeData['activation_ip'],
            'activation_device' => $deCodeData['activation_device'],
            'activation_app_signature' => $deCodeData['activation_app_signature'],
            'app_id' => $app->id,
            'activation_count' => $activationCount,
            'is_single_use' => $cardCode->usage_limit === 0
        ]);


        return $this->returnData($cardCode);

    }

    /**
     * 创建卡密记录
     * @param CardCodes|Model $cardCodes
     * @param array $data
     * @return Model
     */
    protected function addCodeList(CardCodes|Model $cardCodes, array $data): Model
    {
        return $cardCodes->activations()->create([
            'activated_at' => now(),
            'activation_ip' => $data['activation_ip'],
            'activation_device' => $data['activation_device'],
            'activation_app_signature' => $data['activation_app_signature'],
            'app_id' => $data['app_id'],
            'activation_count' => $data['activation_count'],
            'is_single_use' => $data['is_single_use']
        ]);
    }


    /**
     * 心跳验证
     * @param array $data
     * @return array
     * @throws Throwable
     */
    public function heartbeat(array $data): array
    {
        /**
         * $deCodeData 已经解密数据
         * $cardCode 卡密
         * $app 所属App
         */
        list($deCodeData, $cardCode, $app) = $this->decrypt(self::HEART, $data);

        return $this->returnData($cardCode);


    }

    /**
     * 解密并验证
     * @param int $type
     * @param array $data
     * @return array
     * @throws Throwable
     */
    public function decrypt(int $type, array $data): array
    {
        /**
         * base64 add json解码数据
         */
        $deCodeData = json_decode(Base64::decode($data['codes']), true);
        if ($type === self::HEART) {
            $deCodeData = new HeartDataDTO($deCodeData);
        } elseif ($type === self::VERIFY) {
            $deCodeData = new DeCodeDataDTO($deCodeData);
        }
        $deCodeData = $deCodeData->toArray();
        /**
         * 查询卡密
         */
        $cardCode = CardCodes::query()->where('code', $deCodeData['code'])->first();

        /**
         * 查询公钥
         */
        $app = $cardCode->app;


        /**
         * 判断卡密是否存在
         */
        if (!$cardCode) {
            // 若未找到对应的卡密，则抛出异常或进行其他处理
            throw new Exception('卡密不存在');
        }

        if (isset($deCodeData['token'])&&!$cardCode->active) {
            throw new Exception('卡密已被停用');
        }

        /**
         * 校验卡密数据
         */
        if (!$this->EC->verifySignature($deCodeData, $data['sign'], $app->public_key)) {
            throw new Exception('卡密数据校验失败');
        }

        /**
         * 判断卡密是否过期
         */
        if (Carbon::parse($cardCode->expiration_date)->isPast()) {
            throw new Exception('卡密已过期');
        }

        if (isset($deCodeData['token']) && $deCodeData['token'] !== md5($cardCode->secret_key)) {
            throw new Exception('心跳令牌错误');
        }

        return array($deCodeData, $cardCode, $app);
    }

    /**
     * 返回数据
     * @param mixed $cardCode
     * @return array
     */
    public function returnData(mixed $cardCode): array
    {
        $time = Carbon::now()->timestamp;
        $x = md5($cardCode->secret_key);
        return [
            'over_date' => $cardCode->expiration_date,
            'token' => $x,
            'remark' => $cardCode->note,
            'time' => $time,
            'sign' => md5(collect([
                $cardCode->expiration_date,
                $x,
                $time
            ])->toJson())
        ];
    }

    /**
     * @param string $type
     * @param string $privateKey
     * @param array $data
     * @return array
     * @throws Throwable
     */
    public function signature(string $type, string $privateKey, array $data): array
    {
        if ($type === 'heartbeat'){
            $deData = new HeartDataDTO($data);
        }elseif ($type === 'card'){
            $deData = new DeCodeDataDTO($data);
        }
        $deData = $deData->toArray();

        $enData = base64_encode(json_encode($deData));
        $sign = base64_encode($this->EC->generateSignature($deData,$privateKey));

        return [
            'data' => $enData,
            'sign' => $sign
        ];
    }
}
