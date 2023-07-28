<?php

namespace App\Filament\Resources\Card\CardCodesResource\Pages;

use App\Filament\Resources\Card\CardCodesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCardCodes extends EditRecord
{
    protected static string $resource = CardCodesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->before(function (){
                $this->record->activations()->delete();
            }),
        ];
    }
}
