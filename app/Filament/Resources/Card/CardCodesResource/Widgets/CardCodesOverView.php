<?php

namespace App\Filament\Resources\Card\CardCodesResource\Widgets;

use App\Services\CardCodeService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class CardCodesOverView extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';

    protected function getCards(): array
    {
        return [
            Card::make('未使用卡密', CardCodeService::getItOnDemand('Unused'))
            ->description('已添加App：'.CardCodeService::getItOnDemand('AllApp'))
            ->descriptionIcon('heroicon-o-collection'),
            Card::make('可用卡密配额',CardCodeService::getUserQuantity())
            ->description('已生成卡密：'.CardCodeService::getItOnDemand('All')),
            Card::make('已使用卡密', CardCodeService::getItOnDemand('used')),
            Card::make('已过期卡密', CardCodeService::getItOnDemand('Expired')),
        ];
    }
}
