<?php

namespace App\Filament\Clusters\RoomBooking\Resources;

use App\Filament\Clusters\RoomBooking;
use App\Filament\Clusters\RoomBooking\Resources\RoomBookingResource\Pages;
use App\Filament\Clusters\RoomBooking\Resources\RoomBookingResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
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
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
