<?php

namespace App\Filament\Clusters\RoomBooking\Resources;

use App\Filament\Clusters\RoomBooking;
use App\Filament\Clusters\RoomBooking\Resources\RoomBookingResource\Pages;
use App\Filament\Clusters\RoomBooking\Resources\RoomBookingResource\RelationManagers;
use App\Filament\Librarian\Resources\RoomResource;
use App\Filament\Resources\BookResource;
use App\Models\Room;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomBookingResource extends Resource
{
    protected static ?string $model = \App\Models\RoomBooking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = RoomBooking::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Group::make()
                    ->schema([
                        DatePicker::make('booking_date')
                            ->date(),

                        ToggleButtons::make('status')
                            ->inline()
                            ->options([
                                'pending' => 'Pending',
                                'check in' => 'Check In',
                                'check out'  => 'Check Out',
                                'schedule'  => 'Schedule',
                                'cancel' => 'Cancel',
                            ])
                            ->colors([
                                'pending' => 'warning',
                                'check in' => 'success',
                                'check out' => 'gray',
                                'schedule'  => 'primary',
                                'cancel'  => 'danger',
                            ])
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpan(4),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\TimePicker::make('started_time')
                            ->label('Started Time')
                            ->time(),

                        Forms\Components\TimePicker::make('finished_time')
                            ->label('Finished Time')
                            ->time(),

                        TextInput::make('total_price')
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
                            ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : null)
                            ->disabled()
                            ->columnSpan(2)
                    ])
                    ->columns(4)
                    ->columnSpan(4),

                Forms\Components\Section::make('Room')
                    ->relationship('room')
                    ->schema([
                        TextInput::make('name')
                            ->disabled()
                            ->columnSpan(2),
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->disabled(),
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
                            ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : null)
                            ->disabled()



                    ])
                    ->columns(2)
                    ->columnSpan(2)
                    ->disabled()
                    ->headerActions([
                        Forms\Components\Actions\Action::make('view_book')
                            ->label('View Room')
                            ->url(fn ($get) => RoomResource::getUrl('view', ['record' => $get('room_id')]))
                            ->icon('heroicon-o-eye')
                            ->color('primary'),
                    ]),

                Forms\Components\Section::make('Member Profile')
                    ->relationship('member')
                    ->schema([

                        TextInput::make('email')
                            ->columnSpan(2),

                        Forms\Components\Group::make()
                            ->relationship('profile')
                            ->schema([
                                TextInput::make('first_name')
                                    ->label('Name'),

                                TextInput::make('phone')
                                    ->label('Phone'),


                            ])
                            ->columnSpan(2)
                            ->columns(2)
                    ])
                    ->disabled()
                    ->headerActions([
//                        Forms\Components\Actions\Action::make('view_member')
//                            ->label('View Book')
//                            ->url(fn ($get) => BookResource::getUrl('view', ['record' => $get('book_id')]))
//                            ->icon('heroicon-o-eye')
//                            ->color('primary'),
                    ])
                    ->columns(2)
                    ->columnSpan(2),

            ])
            ->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\RoomBooking::query()
                    ->whereHas('room', function ($query) {
                        $query->where('library_id', Filament::auth()->user()->library_id);
                    })
                    ->whereNot('status', 'check out')
            )
            ->columns([
                Tables\Columns\TextColumn::make('member.profile.first_name')
                    ->getStateUsing(function ($record) {
                        return $record->member->profile->first_name . ' ' . $record->member->profile->last_name;
                    })
                    ->label('Member')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('room.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('booking_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'check out' => 'gray',
                        'check in' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                    })
            ])
            ->filters([
                //
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
            'index' => Pages\ListRoomBookings::route('/'),
            'create' => Pages\CreateRoomBooking::route('/create'),
            'edit' => Pages\EditRoomBooking::route('/{record}/edit'),
        ];
    }
}
