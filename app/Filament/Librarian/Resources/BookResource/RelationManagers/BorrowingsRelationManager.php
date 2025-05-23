<?php

namespace App\Filament\Librarian\Resources\BookResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BorrowingsRelationManager extends RelationManager
{
    protected static string $relationship = 'borrowings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('member_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('book.name')
            ->columns([
                Tables\Columns\TextColumn::make('member.profile.first_name')
                    ->getStateUsing(
                        function ($record) {
                            return $record->member->profile->first_name . ' ' . $record->member->profile->last_name;
                        }
                    )
                    ->label('Member')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('member.email')
                    ->label('Member Email')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('borrowed_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('returned_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('code'),

                  TextColumn::make('status')
                      ->badge()
                      ->color(fn (string $state): string => match ($state) {
                          'borrowed'         => 'warning',
                          'returned'         => 'success',
                          'penalty'          => 'danger',
                          'pending'          => 'info',
                          'return requested' => 'info',
                      }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'borrowed'         => 'Borrowed',
                        'returned'         => 'Returned',
                        'penalty'          => 'Penalty',
                        'pending'          => 'Pending',
                        'return requested' => 'Return Requested',
                    ]),

                Tables\Filters\Filter::make('borrowed_date')
                    ->form([
                        DatePicker::make('borrowed_date')
                            ->label('Borrowed Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['borrowed_date'], fn ($query, $date) =>
                            $query->whereDate('borrowed_date', $date));
                    }),

                Tables\Filters\Filter::make('due_date')
                    ->form([
                        DatePicker::make('due_date')
                            ->label('Due Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['due_date'], fn ($query, $date) =>
                            $query->whereDate('due_date', $date));
                    }),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
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
