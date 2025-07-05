<?php

namespace App\Filament\Admin\Resources\ApplicationLogResource\Pages;

use App\Filament\Admin\Resources\ApplicationLogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateApplicationLog extends CreateRecord
{
    protected static string $resource = ApplicationLogResource::class;
}
