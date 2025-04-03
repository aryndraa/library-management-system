<?php

namespace App\Filament\Clusters\Librarian\Resources;

use App\Filament\Clusters\Librarian;
use App\Filament\Clusters\Librarian\Resources\LibrarianShiftResource\Pages;
use App\Filament\Clusters\Librarian\Resources\LibrarianShiftResource\RelationManagers;
use App\Models\LibrarianAbsent;
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

        $today = Carbon::today()->format('l');
        $todayDate = Carbon::today()->toDateString();
        $currentTime = Carbon::now()->format('H:i:s');

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

                TextColumn::make('status')
                    ->label('Presence Status')
                    ->getStateUsing(function ($record) use ($todayDate, $currentTime) {
                        $absent = $record->librarian->absents()
                            ->whereDate('created_at', $todayDate)
                            ->first();

                        if ($absent) {
                            return "Presence";
                        }

                        if ($record->day === Carbon::now()->format('l')) {
                            return ($currentTime > $record->clock_in) ? "Not present" : "Not yet come";
                        }

                        return "-///-";
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '-///-' => 'gray',
                        'Not yet come' => 'warning',
                        'Presence' => 'success',
                        'Not present' => 'danger',
                    }),

                TextColumn::make('clock_in')
                    ->time()
                    ->sortable(),

                TextColumn::make('clock_out')
                    ->time()
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
