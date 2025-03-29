<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Member;
use App\Models\RoomBooking;
use Carbon\Carbon;
use Doctrine\DBAL\SQL\Parser\Visitor;
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
        $todayBorrowedBooks = BorrowedBook::query()
            ->whereDate('borrowed_date', Carbon::today())
            ->count();

        $todayRoomBookings = RoomBooking::query()
            ->whereDate('booking_date', Carbon::today())
            ->count();

        $todayVisitors = DB::table('member_visits')
            ->whereDate('created_at', Carbon::today())
            ->count();

        return [
            Stat::make('Borrowed Books', $todayBorrowedBooks),
            Stat::make('Booking Rooms', $todayRoomBookings),
            Stat::make('Visitors', $todayVisitors),
        ];
    }
}
