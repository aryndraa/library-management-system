<?php

namespace App\Filament\Librarian\Widgets;

use App\Models\BorrowedBook;
use App\Models\RoomBooking;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $filter = $this->filters['time_range'] ?? 'today';
        $librarian = Filament::auth()->user()->library_id;

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
            ->where('library_id', $librarian)
            ->count();

        $todayRoomBookings = RoomBooking::query()
            ->whereDate('booking_date', '>=', $startDate)
            ->whereHas('room', function ($query) use ($librarian) {
                $query->where('library_id', $librarian);
            })
            ->count();

        $todayVisitors = DB::table('member_visits')
            ->whereDate('visit_date', '>=', $startDate)
            ->where('library_id', $librarian)
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
