<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\LibrariesResource;
use App\Models\Library;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TotalVisitorsTable extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Library::query()
                    ->withCount('memberVisits')
            )
            ->defaultPaginationPageOption(5)
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->label('Library Name'),
                Tables\Columns\TextColumn::make('member_visits_count')
                    ->label('Visitors')
                    ->sortable(),
            ]);
    }
}
