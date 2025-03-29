<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class TestBookChart extends ChartWidget
{
    protected static ?string $heading = 'Blog Posts';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected static ?string $maxHeight = "16rem";

    protected static string $color = "secondary";


    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                    'backgroundColor' => 'rgba(255, 210, 93, 0.05)',
                    'fill' => true,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
