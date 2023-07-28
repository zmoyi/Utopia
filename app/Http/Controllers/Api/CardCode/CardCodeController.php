<?php

namespace App\Http\Controllers\Api\CardCode;

use App\DTO\CodeDataDTO;
use App\Http\Controllers\Controller;
use App\Services\Api\CardCodesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class CardCodeController extends Controller
{
    protected CardCodesService $cardCodesService;

    public function __construct(CardCodesService $cardCodesService)
    {
        $this->cardCodesService = $cardCodesService;
    }

    /**
     * 验证卡密
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function verifyCode(Request $request): JsonResponse
    {

        $requestData = new CodeDataDTO($request->all());
        $data = $this->cardCodesService->ActivateCardCode($requestData->toArray());
        return response()->json($data);

    }

    /**
     * 心跳验证
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function heartbeat(Request $request): JsonResponse
    {
        $requestData = new CodeDataDTO($request->all());
        $data = $this->cardCodesService->heartbeat($requestData->toArray());
        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * 签名数据
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function signature(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|string',
            'privateKey' => 'required|string',
            'data' => 'required|array'
        ],[
            'type.required' => 'type必填',
            'type.string' => 'type必需为string类型',
            'privateKey.required' => 'privateKey必填',
            'privateKey.string' => 'privateKey必需为string类型',
            'data.required' => 'data必填',
            'data.array' => 'data必需为array类型',

        ]);
        if ($request->has('type') && $request->has('privateKey') && $request->has('data')) {
            $data = $this->cardCodesService->signature($request->input('type'), $request->input('privateKey'), $request->input('data'));
            return response()->json([
                'data' => $data
            ]);
        } else {
            return response()->json([
                'message' => '数据不完整'
            ], 500);
        }
    }
}
