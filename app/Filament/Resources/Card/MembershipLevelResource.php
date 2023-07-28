<?php

namespace App\Filament\Resources\Card;

use App\Filament\Resources\Card;
use App\Filament\Resources\MembershipLevelResource\Pages;
use App\Models\MembershipLevel;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class MembershipLevelResource extends Resource
{
    protected static ?string $model = MembershipLevel::class;

    protected static ?string $label='会员管理';

    protected static ?string $navigationGroup = '卡密';


    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('会员级别名称')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                        if (!$get('is_slug_changed_manually') && filled($state)) {
                            $set('slug', Str::slug($state));
                        }
                    }),
                TextInput::make('slug')
                    ->afterStateUpdated(function (Closure $set) {
                        $set('is_slug_changed_manually', true);
                    })
                    ->required(),
                Forms\Components\TextInput::make('card_codes_quota')
                    ->label('可生成的卡密数量限额')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('validity_period')
                    ->label('会员级别的有效期（天）')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->label('会员级别的价格')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('discount')
                    ->required()
                    ->numeric()
                    ->step('0.1')
                    ->label('会员级别的折扣比例'),
                Forms\Components\Textarea::make('description')
                    ->label('会员级别的描述'),
            ])->columns(0);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('会员名称')
                ->description(fn(MembershipLevel $record):string=>$record->description),
                Tables\Columns\TextColumn::make('card_codes_quota')
                ->label('可用配额'),
                Tables\Columns\BadgeColumn::make('price')->money('CNY')
                ->label('价格'),
                Tables\Columns\TextColumn::make('validity_period')
                ->label('有效期（天）'),
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
            'index' => Card\MembershipLevelResource\Pages\ListMembershipLevels::route('/'),
            'create' => Card\MembershipLevelResource\Pages\CreateMembershipLevel::route('/create'),
            'edit' => Card\MembershipLevelResource\Pages\EditMembershipLevel::route('/{record}/edit'),
        ];
    }
}
