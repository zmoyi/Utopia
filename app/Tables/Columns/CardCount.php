<?php

namespace App\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class CardCount extends TextColumn
{
    protected string $view = 'tables.columns.card-count';

    public function getState()
    {
//        dd($this->record->cardcodes()->get());
        return $this->record->cardcodes()->count();
    }

}
