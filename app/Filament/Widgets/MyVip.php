<?php

namespace App\Filament\Widgets;

use App\Models\App;
use App\Services\CardCodeService;
use App\Services\UserService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class MyVip extends BaseWidget
{
    protected static ?int $sort = 1;


    protected function getCards(): array
    {
        return [
            Card::make('欢迎登录',auth()->user()->name),
            Card::make('App数量', App::query()->where('user_id',auth()->id())->count())
                ->description('已激活卡密：'.CardCodeService::getItOnDemand('used'))
                ->descriptionIcon('heroicon-s-trending-up'),
            Card::make('会员过期时间',UserService::getUserMemberExpirationDate(auth()->user()))
            ->description('可用配额：'.CardCodeService::getUserQuantity()),
//            Card::make('')
        ];
    }

    protected function getPollingInterval(): ?string
    {
        return '10s';
    }


}
