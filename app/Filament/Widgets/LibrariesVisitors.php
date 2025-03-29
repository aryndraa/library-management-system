<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\LibraryResource;
use App\Models\Library;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LibrariesVisitors extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Library::query()
                    ->withCount('memberVisits')
                    ->orderByDesc('member_visits_count')
            )
            ->defaultPaginationPageOption(5)
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Library Name'),
                Tables\Columns\TextColumn::make('member_visits_count')
                    ->label('Visitors')
                    ->sortable(),
            ]);
    }
}
