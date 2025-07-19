<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ApplicationLogResource\Pages;
use App\Filament\Admin\Resources\ApplicationLogResource\RelationManagers;
use App\Models\ApplicationLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicationLogResource extends Resource
{
    protected static ?string $model = ApplicationLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    protected static ?string $navigationGroup = 'Lamaran';

    protected static ?string $modelLabel = 'Log Lamaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('application_id')
                    ->relationship('application', 'name')
                    ->required()
                    ->label('Lamaran'),

                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->label('Diperbarui Oleh'),

                Forms\Components\TextInput::make('action')
                    ->required()
                    ->label('Aksi'),

                Forms\Components\Textarea::make('message')
                    ->nullable()
                    ->label('Pesan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('application.name')->label('Lamaran'),
                Tables\Columns\TextColumn::make('application.status')->label('Status')->badge()->color(fn (string $state) => match ($state) {
                    'Lamaran Dikirim' => 'gray',
                    'Lamaran Direview' => 'warning',
                    'Interview' => 'info',
                    'Diterima' => 'success',
                    'Ditolak' => 'danger',
                    default => 'secondary',
                }),
                Tables\Columns\TextColumn::make('user.name')->label('Pengguna'),
                Tables\Columns\TextColumn::make('action')->label('Aksi'),
                Tables\Columns\TextColumn::make('message')->label('Pesan')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->since()->label('Waktu'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status Lamaran')
                    ->options([
                        'Lamaran Dikirim' => 'Lamaran Dikirim',
                        'Lamaran Direview' => 'Lamaran Direview',
                        'Interview' => 'Interview',
                        'Diterima' => 'Diterima',
                        'Ditolak' => 'Ditolak',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplicationLogs::route('/'),
            'create' => Pages\CreateApplicationLog::route('/create'),
            'edit' => Pages\EditApplicationLog::route('/{record}/edit'),
        ];
    }
}