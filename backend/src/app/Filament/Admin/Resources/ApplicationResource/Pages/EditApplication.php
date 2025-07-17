<?php

namespace App\Filament\Admin\Resources\ApplicationResource\Pages;

use App\Filament\Admin\Resources\ApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicationLog;

class EditApplication extends EditRecord
{
    protected static string $resource = ApplicationResource::class;

    protected function afterSave(): void
    {
        $user = Auth::user(); // pengguna yang melakukan perubahan
        $application = $this->record;

        ApplicationLog::create([
            'application_id' => $application->id,
            'user_id' => $user?->id ?? 1, // fallback ke ID 1 jika tidak login (optional)
            'action' => 'Update Lamaran',
            'message' => 'Status lamaran diubah menjadi: ' . $application->status,
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
