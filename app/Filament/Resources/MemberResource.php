<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Filament\Resources\MemberResource\RelationManagers;
use App\Models\Member;
use Faker\Provider\Text;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = "Users Management";


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email'),

                Forms\Components\Group::make()
                    ->relationship('profile')
                    ->schema([
                        TextInput::make('first_name')
                            ->label('First Name'),

                        TextInput::make('last_name')
                            ->label('Last Name'),

                        TextInput::make('phone')
                            ->label('Phone Number'),

                        TextInput::make('birthday')
                            ->label('Birthday'),

                        TextInput::make('gender')
                            ->label('Gender'),

                        TextInput::make('address')
                            ->label('Address'),

                        TextInput::make('province')
                            ->label('Province'),

                        TextInput::make('city')
                            ->label('City'),
                    ])
                    ->columns(2)
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('profile.first_name')
                    ->label('Name')
                    ->getStateUsing(function ($record) {
                        return $record->profile->first_name . ' ' . $record->profile->last_name;
                    })
                    ->searchable()
                    ->sortable(),


                TextColumn::make("email")
                    ->searchable()
                    ->sortable(),

                TextColumn::make("profile.phone")
                    ->label('Phone')
                    ->searchable(),

                TextColumn::make("borrowed_books_count")
                    ->label('Total Borrowed Books')
                    ->counts('borrowedBooks')
                    ->sortable(),

                TextColumn::make("room_bookings_count")
                    ->label('Total Booked Rooms')
                    ->counts('roomBookings')
                    ->searchable(),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\BorrowedBooksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
            'view' => Pages\ViewMember::route('/{record}'),
        ];
    }
}
