<?php

namespace App\Filament\Resources\Card\AppResource\Pages;

use App\Filament\Resources\Card\AppResource;
use App\Services\AppService;
use Exception;
use Filament\Pages\Actions;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Livewire\Component as Livewire;

class EditApp extends EditRecord
{
    protected static string $resource = AppResource::class;

    /**
     * @throws Exception
     */
    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()->before(function () {
                $this->record->cardCodes()->delete();
                $this->record->activations()->delete();
            }),

        ];
    }

    protected function getFormActions(): array
    {
        return array_merge(parent::getFormActions(), [
            Actions\Action::make('copy')
                ->label('复制密钥')
                ->action(function (Livewire $livewire) {
                    $livewire->dispatchBrowserEvent('copyPrivateKay');
                }),
        ]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $appService = new AppService();
        $data['private_key'] = $appService->getAndMarkPrivateKey($data['id']);
        if (!is_array($data['custom_fields'])) {
            $data['custom_fields'] = json_decode($data['custom_fields'], true);
        }
        return parent::mutateFormDataBeforeFill($data);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['private_key'] = 'null';
        return parent::mutateFormDataBeforeSave($data);
    }
}
