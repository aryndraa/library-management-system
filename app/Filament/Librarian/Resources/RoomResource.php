<?php

namespace App\Filament\Librarian\Resources;

use App\Filament\Librarian\Resources\RoomResource\Pages;
use App\Filament\Librarian\Resources\RoomResource\RelationManagers;
use App\Models\Room;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Room Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        TextInput::make('name')
                            ->required(),

                        Forms\Components\Select::make('room_category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('library_id')
                            ->relationship('library', 'name')
                            ->searchable()
                            ->default(fn() => Filament::auth()->user()->library_id)
                            ->preload()
                            ->disabled()
                            ->dehydrated(),

                        TextInput::make('price')
                            ->label('Price')
                            ->mask(RawJs::make(<<<'JS'
                                    text => {
                                        let number = text.replace(/[^\d]/g, '');
                                        return new Intl.NumberFormat('id-ID', {
                                            style: 'currency',
                                            currency: 'IDR',
                                            minimumFractionDigits: 0
                                        }).format(number);
                                    }
                                JS))
                            ->dehydrateStateUsing(fn ($state) => (int) preg_replace('/[^\d]/', '', $state))
                            ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : null) ,

                        Forms\Components\Repeater::make('facilities')
                            ->relationship('facilities')
                            ->schema([
                                TextInput::make('facility')
                                    ->label('Name'),

                                Forms\Components\Textarea::make('description')
                                    ->label('Description'),

                            ])
                            ->grid(2)
                            ->columnSpan(2)
                    ])
                    ->columnSpan(2)
                    ->columns(2),

                Forms\Components\Group::make()
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('picture')
                            ->collection('room')
                            ->columnSpan(2),

                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'available' => 'Available',
                                        'booked' => 'Booked',
                                        'maintenance' => 'Maintenance',
                                    ])
                                    ->default('available')
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
                                    ->content(fn ($record) => $record?->bookings()->count() ?? 0)
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
                    ])->columnSpan(['lg' => 1])
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Room::query()->where('library_id', Filament::auth()->user()->library_id)
            )
            ->columns([
                SpatieMediaLibraryImageColumn::make('room')
                    ->label('Picture')
                    ->collection('room')
                    ->height(50)
                    ->width(50),

                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('category.name')
                    ->sortable(),

                TextColumn::make('price')
                    ->money("IDR")
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'booked' => 'warning',
                        'available' => 'success',
                        'maintenance' => 'danger',
                    })
                    ->extraAttributes([
                        'class' => 'capitalize'
                    ]),

            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'booked' => 'Booked',
                        'maintenance' => 'Maintenance',
                    ]),

                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->preload()
                    ->searchable(),
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
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
