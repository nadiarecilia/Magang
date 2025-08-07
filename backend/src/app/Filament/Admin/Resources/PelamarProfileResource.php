<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PelamarProfileResource\Pages;
use App\Models\PelamarProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

class PelamarProfileResource extends Resource
{
    protected static ?string $model = PelamarProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'Manajemen Pelamar';
    protected static ?string $label = 'Profil Pelamar';
    protected static ?string $pluralLabel = 'Profil Pelamar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Akun')
                    ->schema([
                        Grid::make(2)->schema([
                            Forms\Components\Select::make('user_id')
                                ->relationship(
                                    name: 'user',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn ($query) => $query->where('role', 'pelamar')
                                )
                                ->label('Nama Akun')
                                ->required(),

                                Forms\Components\Select::make('user_id')
                                ->relationship(
                                    name: 'user',
                                    titleAttribute: 'email',
                                    modifyQueryUsing: fn ($query) => $query->where('role', 'pelamar')
                                )
                                ->label('Email')
                                ->required(),

                            Forms\Components\FileUpload::make('profile_picture')
                                ->label('Foto Profil')
                                ->directory('profile-pictures')
                                ->image()
                                ->imageEditor()
                                ->disk('public'),
                        ]),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('Data Pribadi')
                    ->schema([
                        Grid::make(3)->schema([
                            Forms\Components\TextInput::make('phone')->label('Nomor Telepon'),
                            Forms\Components\Select::make('gender')
                                ->options([
                                    'laki-laki' => 'Laki-laki',
                                    'perempuan' => 'Perempuan',
                                ])
                                ->label('Jenis Kelamin'),
                            Forms\Components\TextInput::make('id_number')->label('Nomor Identitas'),
                        ]),
                        Grid::make(2)->schema([
                            Forms\Components\TextInput::make('birth_place')->label('Tempat Lahir'),
                            Forms\Components\DatePicker::make('birth_date')->label('Tanggal Lahir'),
                        ]),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->rows(2),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('Pendidikan & Keahlian')
                    ->schema([
                        Grid::make(1)->schema([
                            Forms\Components\Select::make('education_level')
                                ->options([
                                    'SMA/sederajat' => 'SMA/sederajat',
                                    'D3' => 'D3',
                                    'S1' => 'S1',
                                    'S2' => 'S2',
                                    'S3' => 'S3',
                                ])
                                ->label('Tingkat Pendidikan'),

                            Forms\Components\TextInput::make('major')  
                                ->label('Jurusan')
                                ->placeholder('Masukkan Jurusan Anda')
                                ->required()  
                                ->maxLength(255),
                        ]),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile_picture')
                    ->label('Foto')
                    ->circular()
                    ->size(40),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Akun')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')->label('Telepon'),
                Tables\Columns\TextColumn::make('gender')->label('Gender'),
                Tables\Columns\TextColumn::make('education_level')->label('Pendidikan'),
                Tables\Columns\TextColumn::make('major')  // Menambahkan kolom Major
                    ->label('Jurusan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPelamarProfiles::route('/'),
            'create' => Pages\CreatePelamarProfile::route('/create'),
            'edit' => Pages\EditPelamarProfile::route('/{record}/edit'),
        ];
    }
}