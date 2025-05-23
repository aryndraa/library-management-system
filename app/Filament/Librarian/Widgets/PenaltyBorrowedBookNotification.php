<?php

namespace App\Filament\Librarian\Widgets;

use App\Models\BorrowedBook;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PenaltyBorrowedBookNotification extends BaseWidget
{
    protected int | string | array $columnSpan = 2;

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                BorrowedBook::query()
                    ->where('library_id', auth()->user()->library_id)
                    ->where('status', 'penalty')
                    ->orderByDesc('created_at')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('member.first_name')
                    ->getStateUsing(fn ($record) =>
                        $record->member->profile->first_name .
                        ' '
                        . $record->member->profile->last_name
                    ),


                TextColumn::make('book.title')
                    ->limit(20),


                TextColumn::make('code'),
            ])
            ->paginated(false)
            ->recordUrl(
                fn (BorrowedBook $record) => route('filament.librarian.book-borrowing.resources.book-borrowings.view', ['record' => $record])
            );
    }
}
