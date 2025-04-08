<?php

namespace App\Filament\Clusters\RoomBooking\Resources;

use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource;
use App\Filament\Clusters\RoomBooking;
use App\Filament\Clusters\RoomBooking\Resources\RoomBookingPendingResource\Pages;
use App\Filament\Clusters\RoomBooking\Resources\RoomBookingPendingResource\RelationManagers;
use App\Models\RoomBookingPending;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomBookingPendingResource extends Resource
{
    protected static ?string $model = \App\Models\RoomBooking::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';

    protected static ?string $cluster = RoomBooking::class;

    protected static ?string $label = "Pending Bookings";

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\RoomBooking::query()
                    ->whereHas('room', function ($query) {
                        $query->where('library_id', Filament::auth()->user()->library_id);
                    })
                    ->where('status', 'pending')
            )
            ->columns([
                Tables\Columns\TextColumn::make('room.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('member.profile.first_name')
                    ->getStateUsing(function ($record) {
                        return $record->member->profile->first_name . ' ' . $record->member->profile->last_name;
                    })
                    ->label('Member')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('booking_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'check out' => 'gray',
                        'check in' => 'success',
                        'pending' => 'warning',
                        'canceled' => 'danger',
                        'schedule' => 'primary',
                    })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->url(fn ($record) => RoomBookingResource::getUrl('view', ['record' => $record->id]))
                    ->icon('heroicon-o-eye')
                    ->color('primary')
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
            'index' => Pages\ListRoomBookingPendings::route('/'),
            'create' => Pages\CreateRoomBookingPending::route('/create'),
            'edit' => Pages\EditRoomBookingPending::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;

        return (string) $modelClass::where('status', 'pending')->count();
    }
}
