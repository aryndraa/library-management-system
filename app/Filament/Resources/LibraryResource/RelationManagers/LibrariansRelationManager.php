<?php

namespace App\Filament\Resources\LibraryResource\RelationManagers;

use App\Filament\Clusters\Librarian\Resources\LibrarianResource;
use App\Filament\Resources\RoomResource;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LibrariansRelationManager extends RelationManager
{
    protected static string $relationship = 'librarians';

    protected static ?string $recordTitleAttribute = 'email';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255),
                TextInput::make('password')
                    ->required()
                    ->minLength(8)
                    ->password(),
                Group::make()
                    ->relationship('profile')
                    ->schema([
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->required()
                            ->tel(),
                        Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                            ])
                            ->required(),
                        TextInput::make('address'),
                        TextInput::make('province'),
                        TextInput::make('city'),
                        DatePicker::make('birth_date')
                    ])
                    ->columns(2)
                    ->columnSpan(2)

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('email')
            ->columns([
                TextColumn::make('email'),
                TextColumn::make('profile.firstname')
                    ->label('Full Name')
                    ->getStateUsing(function ($record) {
                        return $record->profile->first_name . ' ' . $record->profile->last_name;
                    })
                    ->searchable(),

                TextColumn::make('profile.phone')->label('Phone'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->url(fn ($record): string => LibrarianResource::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-o-eye'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
