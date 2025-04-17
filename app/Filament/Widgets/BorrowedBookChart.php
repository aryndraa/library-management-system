<?php

namespace App\Filament\Widgets;

use App\Models\BorrowedBook;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;

class BorrowedBookChart extends ChartWidget
{
    protected static ?string $heading = 'All Book Borrowed Record';

    protected static ?string $pollingInterval = '10s';

    protected static string $color = "primary";

    protected static ?int $sort = 1;

    public ?string $filter = 'year';

    protected function getFilters(): ?array
    {
        return [
            'year'  => 'This year',
            'month' => 'Last month',
            'week'  => 'Last week',
        ];
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        if ($activeFilter == 'year') {
            $data = Trend::model(BorrowedBook::class)
                ->dateColumn("borrowed_date")
                ->between(
                    start: now()->startOfYear(),
                    end: now()->endOfYear()
                )
                ->perMonth()
                ->count();

            $labels = $data->map(fn ($item) => Carbon::parse($item->date)->translatedFormat('M'))->toArray();
        } elseif ($activeFilter == 'month') {
            $data = Trend::model(BorrowedBook::class)
                ->dateColumn("borrowed_date")
                ->between(
                    start: now()->startOfMonth(),
                    end: now()->endOfMonth()
                )
                ->perWeek()
                ->count();

            $labels = $data->map(function ($item) {
                [$year, $week] = explode('-', $item->date);
                return Carbon::now()->setISODate($year, $week, 1)->translatedFormat('d M');
            })->toArray();
        } elseif ($activeFilter == 'week') {
            $data = Trend::model(BorrowedBook::class)
                ->dateColumn("borrowed_date")
                ->between(
                    start: now()->subDays(6)->startOfDay(),
                    end: now()->endOfDay()
                )
                ->perDay()
                ->count();

            $labels = $data->map(fn ($item) => Carbon::parse($item->date)->translatedFormat('d M'))->toArray();
        } else {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Borrowed Books',
                    'data' => $data->map(fn ($item) => $item->aggregate)->toArray(),
                    'tension' => 0.5,
                    'backgroundColor' => 'rgba(102, 120, 195, 0.05)',
                    'fill' => true,
                    'borderColor' => 'rgba(102, 120, 195, 1)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
