<?php

namespace App\Filament\Clusters\BookBorrowing\Resources;

use App\Filament\Clusters\BookBorrowing;
use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingHistoryResource\Pages;
use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingHistoryResource\RelationManagers;
use App\Filament\Resources\BookResource;
use App\Models\BookBorrowingHistory;
use App\Models\BorrowedBook;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookBorrowingHistoryResource extends Resource
{
    protected static ?string $model = BorrowedBook::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $label = "Borrowed History";

    protected static ?int $navigationSort = 3;

    protected static ?string $cluster = BookBorrowing::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->minLength(6),

                ToggleButtons::make('status')
                    ->inline()
                    ->options([
                        'borrowed' => 'Borrowed',
                        'returned' => 'Returned',
                        'penalty'  => 'Penalty',
                    ])
                    ->colors([
                        'borrowed' => 'warning',
                        'returned' => 'success',
                        'penalty'  => 'danger',
                    ])
                    ->required(),

                Forms\Components\Group::make()
                    ->schema([
                        DatePicker::make('borrowed_date')
                            ->label('Borrowed Date')
                            ->date(),

                        DatePicker::make('due_date')
                            ->label('Due Date')
                            ->date(),
                    ])
                    ->columns(2),

                DatePicker::make('returned_date')
                    ->label('Returned Date')
                    ->date()
                    ->nullable(),

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
                    ->columnSpan(1),

                Forms\Components\Section::make('Book')
                    ->relationship('book')
                    ->schema([
                        TextInput::make('title')
                            ->columnSpan(2),

                        TextInput::make('isbn')
                            ->label('ISBN'),

                        Forms\Components\Group::make()
                            ->relationship('category')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Category'),
                            ])
                    ])
                    ->disabled()
                    ->headerActions([
                        Forms\Components\Actions\Action::make('view_book')
                            ->label('View Book')
                            ->url(fn ($get) => BookResource::getUrl('view', ['record' => $get('book_id')]))
                            ->icon('heroicon-o-eye')
                            ->color('primary'),
                    ])
                    ->columns(2)
                    ->columnSpan(1),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->limit('30')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('book.title')
                    ->limit('25')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('member.first_name')
                    ->getStateUsing(fn ($record) =>
                        $record->member->profile->first_name .
                        ' '
                        . $record->member->profile->last_name
                    )
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'borrowed' => 'warning',
                        'returned' => 'success',
                        'penalty'  => 'danger',
                    }),
            ])
            ->filters([
                //
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
            'index' => Pages\ListBookBorrowingHistories::route('/'),
            'create' => Pages\CreateBookBorrowingHistory::route('/create'),
            'edit' => Pages\EditBookBorrowingHistory::route('/{record}/edit'),
        ];
    }
}
