<?php

namespace App\Livewire;

use App\Models\Room;
use App\Models\RoomBooking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class RoomAction extends Component
{
    public Room $room;

    public $date, $startedTime, $finishedTime, $total;

    public function mount(Room $room)
    {
        $this->room = $room;
    }

    public function updated($property)
    {
        if (in_array($property, ['startedTime', 'finishedTime'])) {
            $this->calculateTotal();
        }
    }

    public function calculateTotal()
    {
        if ($this->startedTime && $this->finishedTime) {
            try {
                $start = Carbon::parse($this->startedTime);
                $end = Carbon::parse($this->finishedTime);

                if ($end->greaterThan($start)) {
                    $hours = max(1, $start->diffInHours($end));
                    $this->total = $hours * $this->room->price;
                } else {
                    $this->total = 0;
                }
            } catch (\Exception $e) {
                $this->total = 0;
            }
        }
    }

    public function bookRoom()
    {
        $this->validate([
            'date' => 'required|date',
            'startedTime' => 'required|date_format:H:i',
            'finishedTime' => 'required|date_format:H:i|after:start_time',
        ]);

        $hasConflict = RoomBooking::where('room_id', $this->room->id)
            ->where('booking_date', $this->date)
            ->where(function ($query) {
                $query->whereBetween('started_time', [$this->startedTime, $this->finishedTime])
                    ->orWhereBetween('finished_time', [$this->startedTime, $this->finishedTime])
                    ->orWhere(function ($query) {
                        $query->where('started_time', '<=', $this->startedTime)
                            ->where('finished_time', '>=', $this->finishedTime);
                    });
            })
            ->exists();

        if ($hasConflict) {
            flash()->error('Booking time clashes with other schedules.');
            return;
        }

        $start = Carbon::parse($this->startedTime);
        $end = Carbon::parse($this->finishedTime);

        $hours = max(1, $start->diffInHours($end));
        $total = $hours * $this->room->price;

        RoomBooking::create([
            'member_id' => Auth::id(),
            'room_id' => $this->room->id,
            'booking_date' => $this->date,
            'started_time' => $this->startedTime,
            'finished_time' => $this->finishedTime,
            'total_price' => $total,
            'status' => 'schedule',
            'code' => 'BRW-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4))
        ]);


        flash()->success('Room booked successfully.');
        $this->reset(['date', 'startedTime', 'finishedTime']);
    }

    public function render()
    {
        return view('livewire.room-action');
    }
}
