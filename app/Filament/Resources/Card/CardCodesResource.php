<?php

namespace App\Filament\Resources\Card;

use App\Filament\Resources\Card;
use App\Filament\Resources\Card\CardCodesResource\Widgets\CardCodesOverView;
use App\Filament\Resources\CardCodesResource\Pages;
use App\Models\CardCodes;
use Filament\Forms;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Collection;


class CardCodesResource extends Resource
{
    protected static ?string $model = CardCodes::class;

    protected static ?string $label = "卡密管理";
    protected static ?string $navigationGroup = '卡密';
    protected static ?int $navigationSort = -3;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form->schema(
            [
                Forms\Components\TextInput::make('code')
                    ->label('卡密')
                    ->required()
                    ->disabled()
                ->columnSpan(2),
                Forms\Components\TextInput::make('usage_limit')
                    ->numeric()
                    ->required()
                    ->mask(fn(Mask $mask) => $mask->minValue(1)->maxValue(10))
                    ->label('可使用次数'),
                Forms\Components\DateTimePicker::make('expiration_date')
                    ->required()
                    ->label('过期时间'),
                Forms\Components\Textarea::make('note')
                    ->label('备注')
                    ->columnSpan(2),
                Forms\Components\Toggle::make('active')
                    ->required()
                    ->label('卡密状态'),
            ]
        )->columns(2);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable(),
                TextColumn::make('code')
                    ->description(fn(CardCodes $record): string => '过期时间；' . $record->expiration_date),
                TextColumn::make('created_at')
                    ->description(fn(CardCodes $record): string => '更新时间：' . $record->updated_at)
                    ->dateTime(),
            ])
            ->defaultSort('id')
            ->filters([
                //
            ])
            ->poll('20s')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                ->before(function (Collection $records){
                    $records->each(function ($item){
                        $item->activations()->delete();
                    });
                }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            CardCodesOverView::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Card\CardCodesResource\Pages\ListCardCodes::route('/'),
            'create' => Card\CardCodesResource\Pages\AddCardCodes::route('/create'),
            'edit' => Card\CardCodesResource\Pages\EditCardCodes::route('/{record}/edit'),
        ];
    }

}
