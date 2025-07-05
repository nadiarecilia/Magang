<?php

namespace App\Filament\Admin\Resources\ApplicationLogResource\Pages;

use App\Filament\Admin\Resources\ApplicationLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApplicationLogs extends ListRecords
{
    protected static string $resource = ApplicationLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
