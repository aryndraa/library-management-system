<?php

namespace App\Filament\Librarian\Pages;

use App\Filament\Librarian\Widgets\BorrowedBookNotifications;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class Dashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    use InteractsWithPageFilters;

    public function getColumns(): int|string|array
    {
        return 4;
    }

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('time_range')
                            ->options([
                                'today' => 'Today',
                                'week'  => 'This Week',
                                'month' => 'This Month',
                                'year'  => 'This Year',
                            ])
                            ->default('today')
                            ->placeholder('-')
                            ->label('Filter by Time Range'),
                    ])
                    ->columns(2),
            ]);
    }

}
