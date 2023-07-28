<?php

namespace App\Filament\Resources\Card\CardCodesResource\Pages;

use App\Filament\Resources\Card\CardCodesResource;
use App\Filament\Resources\Card\CardCodesResource\Widgets\CardCodesOverView;
use App\Models\CardCodes;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class ListCardCodes extends ListRecords
{
    protected static string $resource = CardCodesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CardCodesOverView::class
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->where('user_id', auth()->id());
    }

    protected function getTableFilters(): array
    {
        return [
            TernaryFilter::make('expiration_date')
                ->label('卡密状态')
                ->placeholder('所有卡密')
                ->falseLabel('未过期')
                ->trueLabel('已过期')
                ->queries(
                    true: fn(Builder $builder) => $builder->where('expiration_date', '<=', Carbon::now())->exists(),
                    false: fn(Builder $builder) => $builder->where('expiration_date', '>', Carbon::now())->exists(),
                ),
            TernaryFilter::make('is_used')
                ->label('使用状态')
                ->placeholder('默认')
                ->falseLabel('未使用')
                ->trueLabel('已使用')
                ->queries(
                    true: fn(Builder $builder) => $builder->where('is_used', true)->exists(),
                    false: fn(Builder $builder) => $builder->where('is_used', false)->exists(),
                ),
        ]; // TODO: Change the autogenerated stub
    }

    public function isTableSearchable(): bool
    {
        return true;
    }

    protected function applySearchToTableQuery(Builder $query): Builder
    {
        if (filled($queryData = $this->getTableSearchQuery())) {
            $query->whereIn('id', CardCodes::search($queryData)->keys());
        }
        return $query;
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }

    protected function getTablePollingInterval(): ?string
    {
        return '10s';
    }

}