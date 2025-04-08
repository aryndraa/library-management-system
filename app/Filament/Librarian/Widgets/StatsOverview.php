<?php

namespace App\Filament\Librarian\Widgets;

use App\Models\BorrowedBook;
use App\Models\RoomBooking;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $filter = $this->filters['time_range'] ?? 'today';

        $startDate = match ($filter) {
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::today(),
        };

        $status = match ($filter) {
            'week' => "Last Week",
            'month' => "Last Month",
            'year' => "Last Year",
            default => "Today",
        };

        $todayBorrowedBooks = BorrowedBook::query()
            ->whereDate('borrowed_date', '>=', $startDate)
            ->count();

        $todayRoomBookings = RoomBooking::query()
            ->whereDate('booking_date', '>=', $startDate)
            ->count();

        $todayVisitors = DB::table('member_visits')
            ->whereDate('visit_date', '>=', $startDate)
            ->count();

        return [
            Stat::make('Borrowed Books', $todayBorrowedBooks)
                ->description("$status borrowed books"),
            Stat::make('Booking Rooms', $todayRoomBookings)
                ->description("$status room bookings"),
            Stat::make('Visitors', $todayVisitors)
                ->description("$status visitors")
        ];
    }

}
