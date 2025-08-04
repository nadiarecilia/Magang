<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\JobPostingResource\Pages;
use App\Models\JobPosting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class JobPostingResource extends Resource
{
    protected static ?string $model = JobPosting::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Manajemen Lowongan';
    protected static ?string $label = 'Lowongan';
    protected static ?string $pluralLabel = 'Lowongan Kerja';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                ->default(fn () => auth()->id()),
                
                Forms\Components\Section::make('Informasi superadmin & Kategori')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'category_name')
                                    ->label('Kategori')
                                    ->required(),
                            ]),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Detail Lowongan')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Lowongan')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'bulletList', 'orderedList', 'link',
                                'codeBlock', 'blockquote', 'undo', 'redo',
                            ])
                            ->required(),

                        Forms\Components\RichEditor::make('requirement')
                            ->label('Persyaratan')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'bulletList', 'orderedList', 'link',
                                'codeBlock', 'blockquote', 'undo', 'redo',
                            ])
                            ->required(),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Detail Pekerjaan')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('location')
                                    ->label('Tipe Lokasi')
                                    ->options([
                                        'Remote' => 'Remote',
                                        'Onsite' => 'Onsite',
                                        'Hybrid' => 'Hybrid',
                                    ])
                                    ->required(),

                                Forms\Components\TextInput::make('work_location')
                                    ->label('Lokasi Kerja (Kota/Kabupaten)')
                                    ->placeholder('Contoh: Jakarta, Surabaya, dll')
                                    ->maxLength(255),

                                Forms\Components\Select::make('employment_type')
                                    ->label('Jenis Pekerjaan')
                                    ->options([
                                        'Full-Time' => 'Full-Time',
                                        'Freelance' => 'Freelance',
                                        'Internship' => 'Internship',
                                    ])
                                    ->required(),
                            ]),

                        Forms\Components\TextInput::make('salary')
                            ->label('Gaji')
                            ->default('Negotiable')
                            ->maxLength(255),

                            Forms\Components\TagsInput::make('skills')
                            ->label('Skill yang Dibutuhkan')
                            ->placeholder('Contoh: Laravel, Figma, SEO')
                            ->suggestions([
                                'Laravel', 'ReactJS', 'Figma', 'UI/UX', 'Docker', 'SEO', 'After Effects', 'AWS', 'Google Ads'
                            ])
                            ->splitKeys(['Enter', ','])
                            ->hint('Pisahkan dengan Enter atau Koma')
                            ->dehydrateStateUsing(fn ($state) => implode(', ', $state)),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Status & Deadline')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DatePicker::make('deadline')
                                    ->label('Deadline')
                                    ->required(),

                                Forms\Components\Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'Aktif' => 'Aktif',
                                        'Tidak Aktif' => 'Tidak Aktif',
                                    ])
                                    ->required(),
                            ]),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.category_name')
                    ->label('Kategori')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('employment_type')
                    ->label('Tipe')
                    ->colors([
                        'primary' => 'Full-Time',
                        'warning' => 'Freelance',
                        'success' => 'Internship',
                    ]),

                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi'),

                Tables\Columns\TextColumn::make('work_location')
                    ->label('Wilayah'),

                Tables\Columns\TextColumn::make('salary')
                    ->label('Gaji'),
                
                Tables\Columns\TagsColumn::make('skills')
                    ->label('Skill')
                    ->separator(', ')
                    ->limit(3),

                Tables\Columns\TextColumn::make('deadline')
                    ->label('Tenggat')
                    ->date('d M Y'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'Aktif',
                        'danger' => 'Tidak Aktif',
                    ]),
            ])
            ->defaultSort('deadline', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Tidak Aktif' => 'Tidak Aktif',
                    ]),

                Tables\Filters\SelectFilter::make('employment_type')
                    ->label('Tipe Pekerjaan')
                    ->options([
                        'Full-Time' => 'Full-Time',
                        'Freelance' => 'Freelance',
                        'Internship' => 'Internship',
                    ]),

                Tables\Filters\SelectFilter::make('location')
                    ->label('Tipe Lokasi')
                    ->options([
                        'Remote' => 'Remote',
                        'Onsite' => 'Onsite',
                        'Hybrid' => 'Hybrid',
                    ]),

                Tables\Filters\Filter::make('deadline_soon')
                    ->label('Deadline < 7 Hari')
                    ->query(fn (Builder $query) => $query->where('deadline', '<=', Carbon::now()->addDays(7)))
                    ->toggle(),
            ])
            ->actions([
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
            'index' => Pages\ListJobPostings::route('/'),
            'create' => Pages\CreateJobPosting::route('/create'),
            'edit' => Pages\EditJobPosting::route('/{record}/edit'),
        ];
    }
}
