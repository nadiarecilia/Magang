<?php

namespace App\Filament\Admin\Resources\PelamarProfileResource\Pages;

use App\Filament\Admin\Resources\PelamarProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPelamarProfiles extends ListRecords
{
    protected static string $resource = PelamarProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
