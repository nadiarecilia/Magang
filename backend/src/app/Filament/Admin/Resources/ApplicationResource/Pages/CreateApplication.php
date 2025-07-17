<?php

namespace App\Filament\Admin\Resources\ApplicationResource\Pages;

use App\Filament\Admin\Resources\ApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateApplication extends CreateRecord
{
    protected static string $resource = ApplicationResource::class;

    protected function afterCreate(): void
    {
        $user = Auth::user();
        $application = $this->record;

        ApplicationLog::create([
            'application_id' => $application->id,
            'user_id' => $user?->id ?? 1,
            'action' => 'Buat Lamaran',
            'message' => 'Lamaran dibuat dengan status awal: ' . $application->status,
        ]);
    }
}
