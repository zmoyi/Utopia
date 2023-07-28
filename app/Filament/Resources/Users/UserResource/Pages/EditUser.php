<?php

namespace App\Filament\Resources\Users\UserResource\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Services\UserService;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {

        $userService = new UserService();

        if ($userService->getUserMember($data['id'], 'membership_level') !== null) {
            $data['expiration_date'] = $userService->getUserMember($data['id'], 'expiration_date');
            $data['card_codes_quota'] = $userService->getUserMember($data['id'], 'card_codes_quota');
            $data['member'] = $userService->getMemberName($data['id'])->value('id');
        }
        $data['role'] = $userService->getUserRoles($data['id']);
        return parent::mutateFormDataBeforeFill($data);
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $userService = new UserService();


        if (isset($data['card_codes_quota']) && isset($data['expiration_date']) && $data['member']) {
            $userService->updateUserMember($record, $data['member']);
            $userService->updateUserMemberCardCodesQuota($record, $data['card_codes_quota']);
            $userService->updateUserMemberExpirationDate($record, $data['expiration_date']);
        }else{
            $userService->addUserMembers($record,$data['member']);
        }
        $userService->addRole($record->id, $data['role']);
        return parent::handleRecordUpdate($record, $data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
