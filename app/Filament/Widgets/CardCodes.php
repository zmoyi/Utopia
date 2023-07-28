<?php

namespace App\Filament\Widgets;

use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class CardCodes extends BaseWidget
{

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

   protected static ?string $heading = '卡密列表';


    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'asc';
    }
    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 5;
    }

    protected function getTablePollingInterval(): ?string
    {
        return '10s';
    }


    protected function getTableQuery(): Builder
    {
        return \App\Models\CardCodes::query()->where('user_id', auth()->id());
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('created_at')
                ->label('创建时间')
                ->date()
                ->sortable(),
            Tables\Columns\TextColumn::make('id')
                ->sortable(),
            Tables\Columns\BadgeColumn::make('code')
                ->label('卡密'),
        ];
    }
}
