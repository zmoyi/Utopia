<?php

namespace App\Filament\Resources\Card;

use App\Filament\Resources\Card;
use App\Filament\Resources\CategoriesResource\Pages;
use App\Filament\Resources\CategoriesResource\RelationManagers;
use App\Models\Categories;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class CategoriesResource extends Resource
{
    protected static ?string $model = Categories::class;

    protected static ?string $label = '分类管理';

    protected static ?string $navigationGroup = '卡密';


    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                Textarea::make('description')
                    ->label('Description')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->description(fn (Categories $record): string => $record->description),
                TextColumn::make('user.name'),
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
            'index' => Card\CategoriesResource\Pages\ListCategories::route('/'),
            'create' => Card\CategoriesResource\Pages\CreateCategories::route('/create'),
            'edit' => Card\CategoriesResource\Pages\EditCategories::route('/{record}/edit'),
        ];
    }
}
