<?php

namespace App\Filament\Resources\Card\MembershipLevelResource\Pages;

use App\Filament\Resources\Card\MembershipLevelResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMembershipLevels extends ListRecords
{
    protected static string $resource = MembershipLevelResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
