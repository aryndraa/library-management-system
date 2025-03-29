<?php

namespace App\Filament\Widgets;

use App\Models\RoomBooking;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;

class BookingRoomChart extends ChartWidget
{
    protected static ?string $heading = 'All Booking Room Record';

    protected static ?int $sort = 1;


    protected function getData(): array
    {
        $data = Trend::model(RoomBooking::class)
            ->dateColumn("booking_date")
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear()
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $data->map(fn ($item) => $item->aggregate)->toArray(),
                    'tension' => 0.5,
                ],
            ],
            'labels' => $data->map(fn ($item) => Carbon::parse($item->date)->translatedFormat('M'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
