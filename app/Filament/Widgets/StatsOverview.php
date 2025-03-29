<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Member;
use App\Models\RoomBooking;
use Carbon\Carbon;
use Doctrine\DBAL\SQL\Parser\Visitor;
use Filament\Forms\Components\Select;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 0;


    protected function getStats(): array
    {
        $filter = $this->filters['time_range'] ?? 'today';

        $startDate = match ($filter) {
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::today(),
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
                ->description('Today borrowed books'),
            Stat::make('Booking Rooms', $todayRoomBookings)
                ->description('Today room bookings'),
            Stat::make('Visitors', $todayVisitors)
                ->description('Today visitors')
        ];
    }
}
