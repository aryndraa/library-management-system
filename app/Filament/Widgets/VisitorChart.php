<?php

namespace App\Filament\Widgets;

use App\Models\Member;
use App\Models\MemberVisit;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Illuminate\Support\Facades\DB;

class VisitorChart extends ChartWidget
{
    protected static ?string $heading = 'Visitors Record';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected static ?string $maxHeight = "16rem";

    protected static string $color = "secondary";


    protected function getData(): array
    {
        $data = Trend::model(MemberVisit::class)
            ->dateColumn('visit_date')
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear()
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Total Visits',
                    'data' => $data->map(fn ($item) => $item->aggregate)->toArray(),
                    'backgroundColor' => 'rgba(102, 120, 195, 0.05)',
                    'fill' => true,
                    'tension' => 0.5,
                    'borderColor' => 'rgba(102, 120, 195, 1)',
                ],
            ],
            'labels' => $data->map(fn ($item) => \Carbon\Carbon::parse($item->date)->translatedFormat('M'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
