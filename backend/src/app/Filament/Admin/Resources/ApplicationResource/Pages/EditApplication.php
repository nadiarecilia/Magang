<?php

namespace App\Filament\Admin\Resources\ApplicationResource\Pages;

use App\Filament\Admin\Resources\ApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\ApplicationLog;
use App\Mail\InterviewInvitationMail;
use App\Mail\AcceptanceNotificationMail;

class EditApplication extends EditRecord
{
    protected static string $resource = ApplicationResource::class;

    protected function afterSave(): void
    {
        $user = Auth::user();
        $application = $this->record;

        $formData = $this->form->getRawState();
        $link = $formData['virtual_interview_link'] ?? null;
        $schedule = $formData['virtual_interview_schedule'] ?? null;

        ApplicationLog::create([
            'application_id' => $application->id,
            'user_id' => $user?->id ?? 1,
            'action' => 'Update Lamaran',
            'message' => 'Status lamaran diubah menjadi: ' . $application->status,
        ]);

        if ($application->status === 'Interview') {
            Mail::to($application->email)->send(
                new InterviewInvitationMail($application, $link, $schedule)
            );
        }

        if ($application->status === 'Diterima') {
            Mail::to($application->email)->send(
                new AcceptanceNotificationMail($application)
            );
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}