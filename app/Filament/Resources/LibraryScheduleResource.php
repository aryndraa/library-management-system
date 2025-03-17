<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LibraryScheduleResource\Pages;
use App\Models\LibrarySchedule;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class LibraryScheduleResource extends Resource
{
    protected static ?string $model = LibrarySchedule::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Schedules';

    protected static ?string $navigationGroup = 'Library';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('library_id')
                    ->relationship('library', 'name')
                    ->required()
                    ->label('Library'),

                Select::make('day')
                    ->options([
                        'monday' => 'Monday',
                        'tuesday' => 'Tuesday',
                        'wednesday' => 'Wednesday',
                        'thursday' => 'Thursday',
                        'friday' => 'Friday',
                        'saturday' => 'Saturday',
                        'sunday' => 'Sunday',
                    ])
                    ->required()
                    ->label('Day'),

                TimePicker::make('opening_time')
                    ->required()
                    ->label('Opening Time'),

                TimePicker::make('closing_time')
                    ->required()
                    ->label('Closing Time'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('library.name')->label('Library')->sortable(),
                TextColumn::make('day')->label('Day')->sortable(),
                TextColumn::make('opening_time')->label('Opening Time')->sortable(),
                TextColumn::make('closing_time')->label('Closing Time')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('day')
                    ->options([
                        'monday' => 'Monday',
                        'tuesday' => 'Tuesday',
                        'wednesday' => 'Wednesday',
                        'thursday' => 'Thursday',
                        'friday' => 'Friday',
                        'saturday' => 'Saturday',
                        'sunday' => 'Sunday',
                    ])
                    ->default(strtolower(Carbon::now()->format('l')))
                    ->label('Day Filter'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLibrarySchedules::route('/'),
            'create' => Pages\CreateLibrarySchedule::route('/create'),
            'edit' => Pages\EditLibrarySchedule::route('/{record}/edit'),
        ];
    }
}
