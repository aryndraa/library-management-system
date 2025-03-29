<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\Room;
use App\Models\RoomBooking;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RoomBooking>
 */
class RoomBookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do {
            $bookingDate  = fake()->dateTimeThisYear();
            $startedTime  = fake()->time();
            $exists = RoomBooking::query()->where('booking_date', $bookingDate)
                ->where('started_time', $startedTime)
                ->exists();
        } while ($exists);

        $finishedTime = (clone Carbon::createFromFormat('H:i:s', $startedTime))
            ->addHours(fake()->numberBetween(1, 4))
            ->format('H:i:s');

        $status = $this->determineStatus($bookingDate, $startedTime, $finishedTime);

        return [
            "member_id"     => Member::query()->inRandomOrder()->first()->id,
            "room_id"       => Room::query()->inRandomOrder()->first()->id,
            "booking_date"  => $bookingDate,
            "started_time"  => $startedTime,
            "finished_time" => $finishedTime,
            "status"        => $status,
        ];
    }

    /**
     * Menentukan status peminjaman berdasarkan waktu.
     */
    private function determineStatus($bookingDate, $startedTime, $finishedTime): string
    {
        $now = now();
        $bookingDateFormatted = Carbon::instance($bookingDate)->format('Y-m-d');

        $start = Carbon::createFromFormat('Y-m-d H:i:s', "$bookingDateFormatted $startedTime");
        $finish = Carbon::createFromFormat('Y-m-d H:i:s', "$bookingDateFormatted $finishedTime");

        if ($now->lessThan($start)) {
            return 'pending';
        } elseif ($now->between($start, $finish)) {
            return 'check in';
        } elseif ($now->greaterThan($finish)) {
            return 'check out';
        } else {
            return fake()->randomElement(['canceled', 'expired']);
        }
    }
}


