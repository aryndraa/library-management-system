<?php

namespace App\Filament\Clusters\Librarian\Resources;

use App\Filament\Clusters\Librarian\Resources\LibrarianResource\Pages;
use App\Filament\Clusters\Librarian\Resources\LibrarianResource\RelationManagers;
use App\Models\Librarian;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LibrarianResource extends Resource
{
    protected static ?string $model = Librarian::class;

    protected static ?string $cluster = \App\Filament\Clusters\Librarian::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $recordTitleAttribute = 'email';

    protected static ?string $navigationLabel = 'Profiles';

    protected static ?string $breadcrumb = 'Profiles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Group::make()
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('picture')
                            ->collection('librarian')
                            ->columnSpan(1),

                        Group::make()
                            ->schema([
                                Section::make("Account")
                                    ->schema([
                                        TextInput::make('email')
                                            ->label('Email')
                                            ->required()
                                            ->unique('admins', 'email')
                                            ->email(),

                                        TextInput::make('password')
                                            ->label('Password')
                                            ->password()
                                            ->minLength(8)
                                            ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                                            ->dehydrated(fn ($state) => filled($state))
                                            ->placeholder(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord ? '••••••••' : null)
                                    ]),


                                Section::make('Librarian Profile')
                                    ->relationship('profile')
                                    ->schema([
                                        TextInput::make('first_name')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('last_name')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('phone')
                                            ->required()
                                            ->tel(),
                                        Select::make('gender')
                                            ->options([
                                                'male' => 'Male',
                                                'female' => 'Female',
                                            ])
                                            ->required(),
                                        TextInput::make('address'),
                                        TextInput::make('province'),
                                        TextInput::make('city'),
                                        DatePicker::make('birth_date')
                                    ])
                                ->columns(2),
                            ])
                            ->columnSpan(2),
                    ])
                        ->columns(3)
                        ->columnSpan(3),



                Forms\Components\Section::make()
                    ->schema([
                        Select::make('library_id')
                            ->relationship('library', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(2),
                        Repeater::make('shifts')
                            ->relationship('shifts')
                            ->schema([
                                Select::make('day')
                                    ->options([
                                        'Monday' => 'Monday',
                                        'Tuesday' => 'Tuesday',
                                        'Wednesday' => 'Wednesday',
                                        'Thursday' => 'Thursday',
                                        'Friday' => 'Friday',
                                        'Saturday' => 'Saturday',
                                        'Sunday' => 'Sunday',
                                    ])
                                    ->required(),
                                TimePicker::make('clock_in')
                                    ->required(),
                                TimePicker::make('clock_out')
                                    ->required(),
                            ])
                            ->label('Shifts')
                            ->grid(3)
                            ->columnSpan(2)
                    ])->columns(2)


            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('librarian')
                    ->label('Picture')
                    ->collection('librarian')
                    ->height(50)
                    ->width(50)
                    ->rounded(),
                TextColumn::make('profile.first_name')
                    ->label('Name')
                    ->getStateUsing(function ($record) {
                        return $record->profile->first_name . ' ' . $record->profile->last_name;
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->limit(15)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('profile.phone')
                    ->label("Phone"),
                TextColumn::make('library.name')
                    ->label('Library')
                    ->sortable()
                    ->limit(20)

            ])
            ->extremePaginationLinks()
            ->filters([
                SelectFilter::make('library')
                    ->relationship('library', 'name')
                    ->searchable()
                    ->preload()
                    ->attribute('library.name'),

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function beforeDelete($record)
    {
        $record->absents()->delete();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLibrarians::route('/'),
            'create' => Pages\CreateLibrarian::route('/create'),
            'view' => Pages\ViewLibrarian::route('/{record}'),
            'edit' => Pages\EditLibrarian::route('/{record}/edit'),
        ];
    }
}
