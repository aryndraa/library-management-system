<?php

namespace App\Livewire;

use App\Models\RoomBooking;
use Livewire\Component;

class BookedRoomAction extends Component
{
    public $bookedId;

    public function mount($bookedId)
    {
        $this->bookedId = $bookedId;
    }

    public function cancelBooked()
    {
        $booked = RoomBooking::query()
            ->where('id', $this->bookedId)
            ->first();

        if($booked->status !== 'canceled') {
            $booked->status = 'canceled';
            $booked->save();

            flash()->success('Booking has been cancelled');

            $this->dispatch('close-modal', id: $this->bookedId);
        }
    }

    public function render()
    {
        return view('livewire.booked-room-action');
    }
}
