<?php

namespace App\Filament\Resources\Card\AppResource\Pages;

use App\Filament\Resources\Card\AppResource;
use App\Models\App;
use App\Services\ECService;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CreateApp extends CreateRecord
{
    protected static string $resource = AppResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $esService = new ECService();
        $key = $esService->getEcKey();
        $data['user_id'] = auth()->id();
        $data['public_key'] = $key['publicKey'];
        $data['private_key'] = $key['privateKey'];
        $data['custom_fields'] = json_encode($data['custom_fields']);
        return parent::mutateFormDataBeforeCreate($data);
    }

}
