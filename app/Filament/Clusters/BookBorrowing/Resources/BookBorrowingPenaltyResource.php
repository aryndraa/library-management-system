<?php

namespace App\Filament\Clusters\BookBorrowing\Resources;

use App\Filament\Clusters\BookBorrowing;
use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingPenaltyResource\Pages;
use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingPenaltyResource\RelationManagers;
use App\Filament\Resources\BookResource;
use App\Models\BorrowedBook;
use Carbon\Carbon;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookBorrowingPenaltyResource extends Resource
{
    protected static ?string $model = BorrowedBook::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static ?string $label = "Borrowed Penalties";
    protected static ?int $navigationSort = 3;

    protected static ?string $cluster = BookBorrowing::class;

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
                BorrowedBook::query()
                    ->where('library_id', Filament::auth()->user()->library_id)
                    ->whereDate('due_date', '<=', now())
                    ->whereNot('status', 'returned')
                    ->havingNull('returned_date')
            )
            ->columns([
                TextColumn::make('code')
                    ->limit('30')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('book.title')
                    ->limit('25')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('member.profile.first_name')
                    ->getStateUsing(fn ($record) =>
                        $record->member->profile->first_name .
                        ' '
                        . $record->member->profile->last_name
                    )
                    ->searchable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'          => 'info',
                        'borrowed'         => 'warning',
                        'returned'         => 'success',
                        'penalty'          => 'danger',
                        'return requested' => 'info',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->url(fn ($record) => BookBorrowingResource::getUrl('view', ['record' => $record->id]))
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
            'index' => Pages\ListBookBorrowingPenalties::route('/'),
            'create' => Pages\CreateBookBorrowingPenalty::route('/create'),
            'edit' => Pages\EditBookBorrowingPenalty::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;

        return (string) $modelClass::query()
                ->where('library_id', Filament::auth()->user()->library_id)
                ->whereDate('due_date', '<=', now())
                ->whereNot('status', 'returned')
                ->havingNull('returned_date')
                ->count();
    }
}
