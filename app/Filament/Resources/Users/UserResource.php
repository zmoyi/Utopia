<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\Users;
use App\Models\User;
use App\Services\UserService;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $label = '用户管理';

    protected static ?string $navigationGroup = '用户';

    protected static ?int $navigationSort = -2;


    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('昵称')
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->label('邮箱')
                                    ->required()
                                    ->email(),
                                TextInput::make('password')
                                    ->label('密码')
                                    ->required(fn(Page $livewire) => $livewire instanceof CreateRecord)
                                    ->password()
                                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                    ->dehydrated(fn($state) => filled($state))
                            ]),
                        Forms\Components\Card::make([
                            Forms\Components\CheckboxList::make('role')
                                ->required()
                                ->label('角色')
                                ->columns()
                                ->options(fn(UserService $service) => $service->getRole()),
                            Forms\Components\Select::make('member')
                                ->label('会员级别')
                                ->searchable()
                                ->options(fn(UserService $service) => $service->getMembershipLevel()),
                            Forms\Components\DateTimePicker::make('expiration_date')
                                ->label('会员过期时间')
                                ->hidden(fn(Page $livewire) => $livewire instanceof CreateRecord),
                            Forms\Components\TextInput::make('card_codes_quota')
                                ->hidden(fn(Page $livewire) => $livewire instanceof CreateRecord)
                                ->label('可生成的卡密数量')
                                ->numeric()
                        ])->columns()
                    ]),
            ])->columns([
                'sm' => 3,
                'lg' => 1,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('昵称'),
                Tables\Columns\TextColumn::make('member.card_codes_quota')
                    ->label('可用卡密配额'),
                Tables\Columns\TextColumn::make('app')
                    ->getStateUsing(function (Model $record): int {
                        return $record->apps()->count();
                    })
                    ->label('已创建App'),
                Tables\Columns\TextColumn::make('email')
                    ->label('邮箱'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Users\UserResource\Pages\ListUsers::route('/'),
            'create' => Users\UserResource\Pages\CreateUser::route('/create'),
            'edit' => Users\UserResource\Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
