<?php

namespace App\Filament\Resources\Card;

use App\Filament\Resources\Card\AppResource\Pages;

use App\Models\App;
use App\Services\AppService;
use App\Tables\Columns\CardCount;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Collection;

class AppResource extends Resource
{
    protected static ?string $model = App::class;

    protected static ?string $label = "App管理";
    protected static ?string $navigationGroup = '卡密';

    protected static ?int $navigationSort = -2;


    protected static ?string $navigationIcon = 'heroicon-o-device-mobile';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\Card::make([
                        TextInput::make('name')
                            ->label('App名称')
                            ->required(),
                        Radio::make('type')
                            ->label('App类型')
                            ->required()
                            ->inline()
                            ->default(AppService::SINGLE_CODE)
                            ->disabled()
                            ->options([
                                AppService::SINGLE_CODE => '单码',
                                AppService::MEMBER_VERIFY => '验证'
                            ]),

                    ]),
                ])->columnSpan(3),
                Forms\Components\Group::make([
                    Forms\Components\Card::make([
                        Textarea::make('private_key')
                            ->label('App私钥(只展现一次,请妥善保管)')
                            ->disabled()
                            ->hidden(fn(Page $livewire) => $livewire instanceof CreateRecord),
                        Repeater::make('custom_fields')
                            ->label('自定义字段')
                            ->schema([
                                TextInput::make('key')
                                    ->required(),
                                Textarea::make('value')
                                    ->required()
                            ])->collapsed()
                    ])
                ])->columnSpan(3)

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('昵称'),
                CardCount::make('CardCount')
                    ->label('卡密数量'),
                Tables\Columns\BadgeColumn::make('user.name')
                    ->label('所属用户'),
                Tables\Columns\TextColumn::make('created_at'),
                Tables\Columns\TextColumn::make('updated_at'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([

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
            'index' => Pages\ListApps::route('/'),
            'create' => Pages\CreateApp::route('/create'),
            'edit' => Pages\EditApp::route('/{record}/edit'),
        ];
    }
}
