<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Contracts\View\View;

class Dashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    use InteractsWithPageFilters;

    protected function getHeaderWidgets(): array
    {
        return [
            AccountWidget::class,

        ];
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
