<?php

namespace App\Filament\Admin\Resources\ApplicationLogResource\Pages;

use App\Filament\Admin\Resources\ApplicationLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApplicationLog extends EditRecord
{
    protected static string $resource = ApplicationLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
