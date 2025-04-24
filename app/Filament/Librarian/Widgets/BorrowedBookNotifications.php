<?php

namespace App\Filament\Librarian\Widgets;

use App\Models\BorrowedBook;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class BorrowedBookNotifications extends BaseWidget
{

    protected int | string | array $columnSpan = 2 ;

    protected static ?int $sort = 2;


    public function table(Table $table): Table
    {
        return $table
            ->query(
                BorrowedBook::query()
                    ->where('library_id', auth()->user()->library_id)
                    ->where('status', 'borrowed')
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

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                            'borrowed' => 'primary',
                        'returned' => 'success',
                        'penalty'  => 'danger',
                    }),

                TextColumn::make('borrowed_date')
                    ->date('d M')
                    ->label('date')
                    ->sortable(),

                TextColumn::make('code'),
            ])
            ->paginated(false);
    }
}
