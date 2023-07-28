<?php

namespace App\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{

    protected function getWidgets(): array
    {
        return Filament::getWidgets();
    }

}
