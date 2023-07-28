<?php

namespace App\Filament\Resources\Card\MembershipLevelResource\Pages;

use App\Filament\Resources\Card\MembershipLevelResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMembershipLevel extends EditRecord
{
    protected static string $resource = MembershipLevelResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
