<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ApplicationResource\Pages;
use App\Filament\Admin\Resources\ApplicationResource\RelationManagers;
use App\Models\Application;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Lamaran';
    protected static ?string $pluralModelLabel = 'Lamaran';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('Pelamar')
                ->relationship('user', 'name')
                ->required(),

            Forms\Components\Select::make('job_posting_id')
                ->label('Lowongan')
                ->relationship('jobPosting', 'title')
                ->required(),

            Forms\Components\TextInput::make('name')->label('Nama')->required(),
            Forms\Components\TextInput::make('email')->email()->required(),
            Forms\Components\TextInput::make('phone')->label('Nomor HP')->required(),
            Forms\Components\TextInput::make('domicile')->label('Domisili')->required(),
            Forms\Components\Select::make('education_level')
                ->label('Pendidikan')
                ->options([
                    'SMA/sederajat' => 'SMA/sederajat',
                    'D3' => 'D3',
                    'S1' => 'S1',
                    'S2' => 'S2',
                    'S3' => 'S3',
                ])
                ->required(),
            Forms\Components\Select::make('position_experience')
                ->label('Pengalaman Posisi')
                ->options([
                    '<1 tahun' => '<1 tahun',
                    '1-2 tahun' => '1-2 tahun',
                    '3-5 tahun' => '3-5 tahun',
                    '>5 tahun' => '>5 tahun',
                ])
                ->required(),
            Forms\Components\Textarea::make('impactful_project')->label('Proyek Berdampak')->rows(2),
            Forms\Components\FileUpload::make('cv_file')->label('CV')->directory('applications/cv')->required(),
            Forms\Components\FileUpload::make('portfolio_file')->label('Portofolio')->directory('applications/portfolio'),
            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'Dikirim' => 'Dikirim',
                    'Diproses' => 'Diproses',
                    'Ditolak' => 'Ditolak',
                    'Diterima' => 'Diterima',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Pelamar')->searchable(),
                Tables\Columns\TextColumn::make('jobPosting.title')->label('Lowongan')->searchable(),
                Tables\Columns\TextColumn::make('name')->label('Nama'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                Tables\Columns\TextColumn::make('phone')->label('No HP'),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge()->color(fn (string $state) => match ($state) {
                    'Dikirim' => 'gray',
                    'Diproses' => 'warning',
                    'Ditolak' => 'danger',
                    'Diterima' => 'success',
                }),
                Tables\Columns\TextColumn::make('created_at')->label('Dilamar pada')->dateTime('d M Y H:i'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status Lamaran')
                    ->options([
                        'Dikirim' => 'Dikirim',
                        'Diproses' => 'Diproses',
                        'Ditolak' => 'Ditolak',
                        'Diterima' => 'Diterima',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplications::route('/'),
            'create' => Pages\CreateApplication::route('/create'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}