<?php

namespace App\Filament\Widgets;

use App\Models\RoomBooking;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use RoundingMode;

class IncomeRecordChart extends ChartWidget
{
    protected static ?string $heading = 'Income Records';

    protected static ?int $sort = 5;


    protected function getData(): array
    {
        $incomeData = RoomBooking::query()->selectRaw("MONTH(booking_date) as month, SUM(total_price) as total_income")
            ->whereYear('booking_date', Carbon::now()->year)
            ->where('total_price', '>=', 0)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total_income', 'month')
            ->toArray();

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $incomePerMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $incomePerMonth[] = $incomeData[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Income',
                    'data' => $incomePerMonth,
                    'backgroundColor' => 'rgba(102, 120, 195, 1)',
                    'borderColor' => 'rgba(102, 120, 195, 1)',
                    'borderWidth' => 2,
                    'fill' => true,
                    
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
