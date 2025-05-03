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
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\RawJs;
use Illuminate\Support\Str;

class CreateRoomBooking extends CreateRecord
{
    protected static string $resource = RoomBookingResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()
                    ->schema([

                        Select::make('member_id')
                            ->label('Member')
                            ->relationship('member', 'email')
                            ->preload()
                            ->searchable()
                            ->columnSpan(2),

                        Select::make('room_id')
                            ->label('Room')
                            ->options(function () {
                                $libraryId = Filament::auth()->user()->library_id;

                                return Room::where('library_id', $libraryId)
                                    ->pluck('name', 'id');
                            })
                            ->preload()
                            ->searchable()
                            ->reactive()
                            ->columnSpan(2),

                        Group::make()
                            ->schema([
                                DatePicker::make('booking_date')
                                    ->date()
                                    ->columnSpan(2),

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

                            ])
                            ->columns(4)
                            ->columnSpan(4),
                    ])
                    ->columns(4),


                Section::make()
                    ->schema([

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
                            ->required()
                            ->columnSpan(2),
                    ]),
        ]);
    }

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = 'BRW-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4));

        return $data;
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
