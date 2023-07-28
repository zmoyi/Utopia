<?php

namespace App\Filament\Resources\Card\CardCodeActivationResource\Pages;

use App\Filament\Resources\Card\CardCodeActivationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCardCodeActivations extends ListRecords
{
    protected static string $resource = CardCodeActivationResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->where('user_id', auth()->id());
    }
}
