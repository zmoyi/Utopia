<?php

namespace App\Http\Controllers;

use App\Events\UserDataAdded;
use App\Models\App;
use App\Services\CardCodeService;
use App\Services\ECService;
use App\Services\OTPService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use phpseclib3\Crypt\EC;

class IndexController extends Controller
{
    function index(CardCodeService $service)
    {
//        dd($service->getEcKey());
//        $privateKey = 'LS0tLS1CRUdJTiBQUklWQVRFIEtFWS0tLS0tDQpNSUdIQWdFQU1CTUdCeXFHU000OUFnRUdDQ3FHU000OUF3RUhCRzB3YXdJQkFRUWdWb1JlekR6SjRGSXB2UExIDQp4OXFHS2lLVHNMZWlsb2poV3hQMVEvRWJNQXloUkFOQ0FBU2hqSDgrQmJteC90WkFDOG5qQVhlTmcwVW9qRTFrDQpQbWcrNzFyMWlSelZPV0VrQUdmTXlMNVRzSkRZNWdwaENtdWx2QW5VRmVLWXNHNHlPSnZNRTkyMQ0KLS0tLS1FTkQgUFJJVkFURSBLRVktLS0tLQ==';
//        $pub = 'LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0NCk1Ga3dFd1lIS29aSXpqMENBUVlJS29aSXpqMERBUWNEUWdBRXY5ekJjZFN2d2thL2l1ZkNzcVFrRWVLVWp0VnENCm1MUW52STVDa2pERmdMY2lGckRxZVJSaEs1Nm1HajhRNjYrK3p6THEzNktkbjgyYytxbTdBVXU4Vnc9PQ0KLS0tLS1FTkQgUFVCTElDIEtFWS0tLS0t';
//        $data = [
//            'code' => 'oEv3wWMAmVuPva6', // code 字段必须存在且为字符串
//            'activation_device' => 'iphone14', // 设备字段必须存在且为字符串
//            'activation_ip' => '127.0.0.1', // IP 字段必须存在且为有效 IP 地址
//            'activation_app_signature' => 'com.subs.app', // 项目签名字段必须存在且为字符串
//            'timestamp' => '1690392601'
//        ];
//
//
//        $sign = $service->generateSignature($data,$privateKey);
//        $sign = base64_encode($sign);
//        $data_s = base64_encode(json_encode($data));
//        dd($sign,$data_s);
//        $v= $service->verifySignature($data,$sign,$pub);
//        dd($v);

//        $s = $service->generatedKey(1);
//        $v = $service->deKey($s);
//        dd($v[0],$s);
        $a = collect([
            'a' => 'm',
            'b' => 'c'
        ])->toJson();
        dd($a);
    }
}
