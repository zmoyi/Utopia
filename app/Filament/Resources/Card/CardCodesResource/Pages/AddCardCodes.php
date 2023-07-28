<?php

namespace App\Filament\Resources\Card\CardCodesResource\Pages;

use App\Events\UserDataAdded;
use App\Filament\Resources\Card\CardCodesResource;
use App\Filament\Widgets\MyVip;
use App\Services\AppService;
use App\Services\CardCodeService;
use App\Services\CategoryService;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class AddCardCodes extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = CardCodesResource::class;

    protected static ?string $title = '添加卡密';

    protected static string $view = 'filament.resources.card-codes-resource.pages.add-card-codes';

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CardCodesResource\Widgets\CardCodesOverView::class
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Group::make([
                Card::make([
                    Select::make('category_id')
                        ->label('所属分类')
                        ->required()
                        ->options(fn(CategoryService $categoryService) => $categoryService->getCategoryAll()->pluck('name', 'id'))
                        ->searchable(),
                    Select::make('app_id')
                        ->label('所属App')
                        ->required()
                        ->options(fn(AppService $appService) => $appService->getAppAll()->pluck('name', 'id'))
                        ->searchable(),
                    DateTimePicker::make('expiration_date')
                        ->default(Carbon::now()->addDays(10))
                        ->required()
                        ->label('到期时间(默认一个月后)'),
                    TextInput::make('usage_limit')
                        ->label('可使用次数(默认为1次)')
                        ->required()
                        ->default(1)
                        ->numeric()
                        ->mask(fn(TextInput\Mask $mask) => $mask->numeric()->minValue(1)),
                    TextInput::make('quantity')
                        ->gte('1')
                        ->required()
                        ->hint('[没有配额？**联系管理员**帮您添加吧！！！](https://kami.subt.cn/admin/card-codes/create)')
                        ->label('添加数量')
//                        ->default(CardCodeService::getUserQuantity())
                        ->numeric()
                        ->helperText('可用配额**' . CardCodeService::getUserQuantity() . '张**')
                        ->mask(fn(TextInput\Mask $mask) => $mask->numeric()->minValue(1)->maxValue(CardCodeService::getUserQuantity())),
                    Textarea::make('note')
                        ->label('备注')
                ]),
            ]),
        ];
    }

    public function submit(): void
    {
        $this->create();
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $data['user_id'] = auth()->id();
        $data['is_used'] = false;
        $quantity = $data['quantity'];
        $cardCodeData = [];
        for ($i = 1; $i <= $quantity; $i++) {
            unset($data['quantity']);
            $cardCodeData[] = $data;
        }
        UserDataAdded::dispatch($cardCodeData, auth()->user());

        $this->redirect(CardCodesResource::getUrl());
        Notification::make()
            ->title('生成卡密中请稍后~~~')
            ->success()
            ->send();
    }

    protected function onValidationError(ValidationException $exception): void
    {
        Notification::make()
            ->title($exception->getMessage())
            ->danger()
            ->send();
    }
}
