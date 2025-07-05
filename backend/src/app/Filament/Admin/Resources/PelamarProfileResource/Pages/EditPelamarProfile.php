<?php

namespace App\Filament\Admin\Resources\PelamarProfileResource\Pages;

use App\Filament\Admin\Resources\PelamarProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPelamarProfile extends EditRecord
{
    protected static string $resource = PelamarProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
