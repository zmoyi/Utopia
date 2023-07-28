<?php

namespace App\Filament\Resources\Card;

use App\Filament\Resources\Card;
use App\Filament\Resources\CardCodeActivationResource\Pages;
use App\Filament\Resources\CardCodeActivationResource\RelationManagers;
use App\Models\CardCodeActivation;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class CardCodeActivationResource extends Resource
{
    protected static ?string $model = CardCodeActivation::class;

    protected static ?string $navigationGroup = '卡密';

    protected static ?int $navigationSort = 5;


    protected static ?string $label = '卡密记录';
    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cardCode.code')
                ->label('卡密'),
                Tables\Columns\TextColumn::make('activation_ip')
                ->label('激活Ip'),
                Tables\Columns\TextColumn::make('activation_device')
                ->label('激活设备'),
                Tables\Columns\TextColumn::make('created_at')
                ->label('创建时间'),
                Tables\Columns\TextColumn::make('updated_at')
                ->label('修改时间'),
            ])
            ->filters([
                //
            ])
            ->actions([

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
            'index' => Card\CardCodeActivationResource\Pages\ListCardCodeActivations::route('/'),
        ];
    }
}
