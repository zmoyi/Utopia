<?php

namespace App\Services;

use App\DTO\CardCodeDTO;
use App\Events\UserDataAdded;
use App\Jobs\AddCardCodeJob;
use App\Models\App;
use App\Models\CardCodes;
use App\Models\User;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Bus\Batch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Throwable;
use Vinkla\Hashids\HashidsManager;

class CardCodeService
{
    protected HashidsManager $hashids;
    protected BaseService $service;

    public function __construct(HashidsManager $hashids, BaseService $service)
    {
        $this->service = $service;
        $this->hashids = $hashids;
    }

    /**
     * 通过事件获取数据并添加
     * @param UserDataAdded $event
     * @return void
     * @throws Throwable
     */
    function getDataAddQueue(UserDataAdded $event): void
    {
        $data = collect($event->cardData)->map(function (array $item) use ($event) {
            return new AddCardCodeJob($item, $event->user);
        });
        Bus::batch($data)
            ->then(function (Batch $batch) use($event,$data) {
                Notification::make()
                    ->title('完成'.$batch->id)
                    ->success()
                    ->body('卡密已全部生成,共'.$data->count().'条卡密')
                    ->sendToDatabase($event->user);
                $CardCodesQuota = $event->user->member->card_codes_quota - $data->count();
                (new UserService())->updateUserMemberCardCodesQuota($event->user,$CardCodesQuota);
            })->catch(function (Batch $batch, Throwable $e) use ($event) {
                Notification::make()
                    ->title('卡密生成失败')
                    ->danger()
                    ->body('失败原因：'.$e->getMessage())
                    ->sendToDatabase($event->user);
            })->finally(function (Batch $batch) {
                // 批处理已完成执行...
            })->dispatch();
    }

    /**
     * 添加卡密数据
     * @param array $item
     * @return Exception|Builder|Model|string|Throwable
     * @throws Throwable
     */
    function addToCardCode(array $item): Model|Builder|Throwable|Exception|string
    {
        $item['code'] = $this->generatedCode(rand($item['app_id'], Carbon::now()->timestamp), (int)$item['category_id']);

        $item['secret_key'] = $this->generatedKey(rand($item['app_id'],Carbon::now()->timestamp));
        $item['active'] = false;
        $item['expiration_action'] = 'Deactivate';

        $data = new CardCodeDTO($item);
        return CardCodes::query()->create($data->toArray());

    }

    /**
     * 生成卡密
     * @param int $id
     * @param int $category_id
     * @return string
     */
    function generatedCode(int $id, int $category_id): string
    {
        return $this->hashids->encode($id, $category_id);
    }

    /**
     * 生成key
     * @param $id
     * @return string
     */
    function generatedKey($id): string
    {
        return $this->hashids->encode($id);
    }

    /**
     * 解密key
     * @param $id
     * @return array
     */
    function deKey($id): array
    {
        return $this->hashids->decode($id);
    }

    /**
     * 按需求获取
     * @param string $data
     * @return int|null
     */
    public static function getItOnDemand(string $data): ?int
    {
        return match ($data) {
            'All' => CardCodes::query()->where('user_id', auth()->id())->count(),
            'AllApp' => App::query()->where('user_id', auth()->id())->count(),
            'Unused' => CardCodes::query()->where('user_id', auth()->id())->where('is_used', false)->count(),
            'used' => CardCodes::query()->where('user_id', auth()->id())->where('is_used', true)->count(),
            'Expired' => CardCodes::query()->where('user_id', auth()->id())->where('expiration_date', '<', Carbon::now())->count(),
        };
    }

    public static function getUserQuantity()
    {
        if (!isset(\auth()->user()->member->card_codes_quota)){
            return 0;
        }
        return \auth()->user()->member->card_codes_quota;
    }
}
