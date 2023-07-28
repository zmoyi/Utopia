<?php

namespace App\Services;

use App\Models\App;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HigherOrderCollectionProxy;

class AppService
{
    /**
     * 单码应用
     */
    const SINGLE_CODE = 'singleCode';

    /**
     * 会员验证应用
     */
    const MEMBER_VERIFY = 'memberVerify';

    /**
     * 获取user所有App
     * @return Collection
     */
    public function getAppAll(): Collection
    {
        return App::query()->where('user_id',auth()->id())->get();
    }

    /**
     * 根据ID获取App
     * @param int $id
     * @return Model|Collection|Builder|array|null
     */
    public function getAppItemById(int $id): Model|Collection|Builder|array|null
    {
        return App::query()->find($id);
    }


    /**
     * 获取私钥
     * @param int $appId
     * @return HigherOrderBuilderProxy|HigherOrderCollectionProxy|mixed
     */
    public function getAndMarkPrivateKey(int $appId): mixed
    {
        $app = App::query()->find($appId);
        $appKey = $app->private_key;
        $app->private_key = 'null';
        $app->save();
        return $appKey;
    }

}
