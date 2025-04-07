<?php

namespace App\Filament\Librarian\Resources\BookResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookCommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'bookComments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->relationship('member')
                    ->schema([
                        Forms\Components\Group::make()
                            ->relationship('profile')
                            ->schema([
                                Forms\Components\Placeholder::make('name')
                                    ->content(
                                        function ($record) {
                                            return $record->first_name . ' ' . $record->last_name;
                                        }
                                    ),

                            ]),

                        TextInput::make('email')
                    ])->columns(2)
                    ->columnSpan(2),

                Forms\Components\Textarea::make('message')
                    ->columnSpan(2),

                Repeater::make('replies')
                    ->relationship('replies')
                    ->schema([
                        Forms\Components\Textarea::make('message')
                    ])
                    ->columnSpan(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('book.title')
            ->columns([
                Tables\Columns\TextColumn::make('member.profile.first_name')
                    ->getStateUsing(
                        function ($record) {
                            return $record->member->profile->first_name . ' ' . $record->member->profile->last_name;
                        }
                    )
                    ->sortable()
                    ->searchable()
                    ->label('Member Name'),

                Tables\Columns\TextColumn::make('message')
                    ->limit(50)
                    ->label('Comments'),

                Tables\Columns\TextColumn::make('created_at')
                    ->date()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
