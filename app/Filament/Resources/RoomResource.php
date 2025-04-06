<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Resources';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        TextInput::make('name'),
                        Forms\Components\Group::make()
                            ->relationship('category')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Category'),
                            ]),

                        Forms\Components\Group::make()
                            ->relationship('library')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Library'),
                            ]),

                        TextInput::make('price')
                            ->mask(RawJs::make(<<<'JS'
                                text => {
                                    let number = text.replace(/[^\d]/g, '');
                                    return new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 0
                                    }).format(number);
                                }
                                JS)),

                        Forms\Components\Repeater::make('facilities')
                            ->relationship('facilities')
                            ->schema([
                                TextInput::make('facility')
                                    ->label('Name'),

                                Forms\Components\Textarea::make('description')
                                    ->label('Description'),

                            ])

                    ])
                    ->columnSpan(2)
                    ->columns(2),

                Forms\Components\Section::make()
                    ->schema([
                        TextInput::make('status')
                            ->label('Status')
                            ->hint(function ($state) {
                                return match ($state) {
                                    'available' => 'Available',
                                    'booked' => 'Booked',
                                    'maintenance' => 'Maintenance',
                                    default => 'Unknown',
                                };
                            })
                            ->hintColor(function ($state) {
                                return match ($state) {
                                    'available' => 'success',
                                    'booked' => 'warning',
                                    'maintenance' => 'danger',
                                    default => 'gray',
                                };
                            }),

                        Forms\Components\Placeholder::make('total_bookings')
                            ->label('Total Bookings')
                            ->content(fn ($record) => $record->bookings()->count())
                            ->disabled(),

                        Placeholder::make('total_income')
                            ->label('Total Income')
                            ->content(function ($record) {
                                if (!$record) return 'Rp 0';

                                $totalBooking = $record->bookings()->count();
                                $price = $record->price ?? 0;
                                $totalIncome = $totalBooking * $price;

                                return 'Rp ' . number_format($totalIncome, 0, ',', '.');
                            })
                            ->disabled(),
                    ])
                    ->columnSpan(['lg' => 1])
            ])
            ->columns(3);


    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category.name')
                    ->sortable(),
                TextColumn::make('library.name')
                    ->sortable(),
                TextColumn::make('price')
                    ->money("USD")
                    ->sortable(),

            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->preload()
                    ->searchable(),

                SelectFilter::make('library')
                    ->relationship('library', 'name')
                    ->label('Library')
                    ->preload()
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListRooms::route('/'),
            'view' => Pages\ViewRoom::route('/{record}'),
        ];
    }
}
