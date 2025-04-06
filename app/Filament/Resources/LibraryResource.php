<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LibraryResource\Pages;
use App\Filament\Resources\LibraryResource\RelationManagers;
use App\Models\Library;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LibraryResource extends Resource
{
    protected static ?string $model = Library::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = "Library Operations";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Group::make()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('address')
                            ->required(),
                        TextInput::make('email')
                            ->required(),
                        TextInput::make('phone')
                            ->required(),
                        TimePicker::make('opening_time')
                            ->required(),
                        TimePicker::make('closing_time')
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpan(2)
                ,

                Section::make('Library Stats')
                    ->schema([
                        Placeholder::make('total_books')
                            ->label('Total Books')
                            ->content(fn ($record) => $record->books()->count())
                            ->disabled(),

                        Placeholder::make('total_librarians')
                            ->label('Total Librarians')
                            ->content(fn ($record) => $record->librarians()->count())
                            ->disabled(),

                        Placeholder::make('total_rooms')
                            ->label('Total Rooms')
                            ->content(fn ($record) => $record->rooms()->count())
                            ->disabled(),

                        Placeholder::make('total_visits')
                            ->label('Total Visits')
                            ->content(fn ($record) => $record->memberVisits()->count())
                        ,

                        Placeholder::make('total_income')
                            ->label('Total Income')
                            ->content(function ($record) {
                                $total = 0;

                                foreach ($record->rooms as $room) {
                                    $total += $room->bookings->sum('total_price');
                                }

                                return 'Rp ' . number_format($total, 0, ',', '.');
                            })
                            ->disabled()
                            ->columnSpan(2)


                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);


    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Library')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address')
                    ->limit(20),
                TextColumn::make('email'),
                TextColumn::make('phone')
            ])
            ->filters([

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

    public static function getRelations(): array
    {
        return [
            RelationManagers\BooksRelationManager::class,
            RelationManagers\LibrariansRelationManager::class,
            RelationManagers\RoomsRelationManager::class,
            RelationManagers\MemberVisitsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLibraries::route('/'),
            'create' => Pages\CreateLibrary::route('/create'),
            'view' => Pages\ViewLibrary::route('/{record}'),
            'edit' => Pages\EditLibrary::route('/{record}/edit'),
        ];
    }
}
