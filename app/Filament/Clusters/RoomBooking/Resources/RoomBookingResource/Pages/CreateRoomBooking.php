<?php

namespace App\Filament\Clusters\RoomBooking\Resources\RoomBookingResource\Pages;

use App\Filament\Clusters\RoomBooking\Resources\RoomBookingResource;
use App\Models\Room;
use App\Models\RoomBooking;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\RawJs;

class CreateRoomBooking extends CreateRecord
{
    protected static string $resource = RoomBookingResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('member_id')
                    ->label('Member')
                    ->relationship('member', 'email')
                    ->preload()
                    ->searchable(),

                Select::make('room_id')
                    ->label('Room')
                    ->options(function () {
                        $libraryId = Filament::auth()->user()->library_id;

                        return Room::where('library_id', $libraryId)
                            ->pluck('name', 'id');
                    })
                    ->preload()
                    ->searchable()
                    ->reactive(),

                Group::make()
                    ->schema([
                        DatePicker::make('booking_date')
                            ->date(),

                        ToggleButtons::make('status')
                            ->inline()
                            ->options([
                                'pending' => 'Pending',
                                'schedule'  => 'Schedule',
                                'check in' => 'Check In',
                                'check out'  => 'Check Out',
                                'cancel' => 'Cancel',
                            ])
                            ->colors([
                                'pending' => 'warning',
                                'check in' => 'success',
                                'check out' => 'gray',
                                'schedule'  => 'primary',
                                'cancel'  => 'danger',
                            ])
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpan(4),

                Group::make()
                    ->schema([
                        TimePicker::make('started_time')
                            ->label('Started Time')
                            ->time()
                            ->rules([
                                function (callable $get) {
                                    return function (string $attribute, $value, \Closure $fail) use ($get) {
                                        $roomId = $get('room_id');
                                        $date = $get('booking_date');
                                        $startTime = Carbon::parse($value);
                                        $endTime = Carbon::parse($get('finished_time'));

                                        if (! $roomId || ! $date || !$get('finished_time')) return;

                                        $conflict = RoomBooking::where('room_id', $roomId)
                                            ->where('booking_date', $date)
                                            ->where(function ($query) use ($startTime, $endTime) {
                                                $query->whereBetween('started_time', [$startTime, $endTime->copy()->subMinute()])
                                                    ->orWhereBetween('finished_time', [$startTime->copy()->addMinute(), $endTime])
                                                    ->orWhere(function ($q) use ($startTime, $endTime) {
                                                        $q->where('started_time', '<', $startTime)
                                                            ->where('finished_time', '>', $endTime);
                                                    });
                                            })
                                            ->exists();

                                        if ($conflict) {
                                            $fail('Waktu mulai bertabrakan dengan jadwal lain.');
                                        }
                                    };
                                }
                            ]),

                        TimePicker::make('finished_time')
                            ->label('Finished Time')
                            ->time(),

                        TextInput::make('total_price')
                            ->mask(RawJs::make(<<<'JS'
                                        text => {
                                            let number = text.replace(/[^\d]/g, '');
                                            return new Intl.NumberFormat('id-ID', {
                                                style: 'currency',
                                                currency: 'IDR',
                                                minimumFractionDigits: 0
                                            }).format(number);
                                        }
                                    JS))
                            ->dehydrateStateUsing(fn ($state) => (int) preg_replace('/[^\d]/', '', $state))
                            ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : null)
                            ->disabled()
                            ->columnSpan(2)
                    ])
                    ->columns(4)
                    ->columnSpan(4),
        ]);
    }

    protected function afterCreate(): void
    {
        $booking = $this->record;

        if (! $booking->started_time || ! $booking->finished_time || ! $booking->room) {
            return;
        }

        $start = Carbon::parse($booking->started_time);
        $end = Carbon::parse($booking->finished_time);

        $hours = max(1, $start->diffInHours($end));
        $total = $hours * $booking->room->price;

        $booking->update([
            'total_price' => $total,
        ]);
    }
}
