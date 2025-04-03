<?php

namespace App\Filament\Clusters\Librarian\Resources;

use App\Filament\Clusters\Librarian;
use App\Filament\Clusters\Librarian\Resources\LibrarianShiftResource\Pages;
use App\Filament\Clusters\Librarian\Resources\LibrarianShiftResource\RelationManagers;
use App\Models\LibrarianShift;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LibrarianShiftResource extends Resource
{
    protected static ?string $model = LibrarianShift::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-date-range';

    protected static ?string $cluster = Librarian::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        $today = Carbon::today()->format('l');

        return $table
            ->columns([
                TextColumn::make('librarian.profile.full_name')
                    ->searchable()
                    ->label('Name')
                    ->getStateUsing(function ($record) {
                        return $record->librarian->profile->first_name . ' ' . $record->librarian->profile->last_name;
                    })
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('day')
                    ->label('Day')
                    ->options([
                        'Monday' => 'Monday',
                        'Tuesday' => 'Tuesday',
                        'Wednesday' => 'Wednesday',
                        'Thursday' => 'Thursday',
                        'Friday' => 'Friday',
                        'Saturday' => 'Saturday',
                        'Sunday' => 'Sunday',
                    ])
                    ->placeholder("Today")
                    ->preload()
                    ->default($today)
                    ->searchable()

            ])
            ->actions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLibrarianShifts::route('/'),
            'create' => Pages\CreateLibrarianShift::route('/create'),
            'edit' => Pages\EditLibrarianShift::route('/{record}/edit'),
        ];
    }
}
