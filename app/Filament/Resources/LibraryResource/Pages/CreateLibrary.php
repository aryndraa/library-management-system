<?php

namespace App\Filament\Resources\LibraryResource\Pages;

use App\Filament\Resources\LibraryResource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\HtmlString;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CreateLibrary extends CreateRecord
{
    protected static string $resource = LibraryResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Group::make()
                            ->schema([
                                TextInput::make('name')
                                    ->required(),
                                TextInput::make('address')
                                    ->required(),
                                TextInput::make('email')
                                    ->required(),
                                TextInput::make('phone')
                                    ->required(),
                                TimePicker::make('opening_time')
                                    ->required(),
                                TimePicker::make('closing_time')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->columnSpan(2),

                        SpatieMediaLibraryFileUpload::make('picture')
                            ->collection('library')
                            ->multiple()
                            ->imagePreviewHeight(100)
                            ->imageCropAspectRatio('16:9')
                            ->maxParallelUploads(3)
                            ->panelLayout('grid')
                            ->maxFiles(3)
                            ->columnSpan(2)
                            ->label("Library Images"),

                    ])
                    ->columnSpan(2),


                Group::make()
                    ->schema([

                        Section::make('Library Stats')
                            ->schema([
                                Placeholder::make('total_books')
                                    ->label('Total Books')
                                    ->content(fn ($record) => $record?->books()->count() ?? 0)
                                    ->disabled(),

                                Placeholder::make('total_librarians')
                                    ->label('Total Librarians')
                                    ->content(fn ($record) => $record?->librarians()->count() ?? 0)
                                    ->disabled(),

                                Placeholder::make('total_rooms')
                                    ->label('Total Rooms')
                                    ->content(fn ($record) => $record?->rooms()->count() ?? 0)
                                    ->disabled(),

                                Placeholder::make('total_visits')
                                    ->label('Total Visits')
                                    ->content(fn ($record) => $record?->memberVisits()->count() ?? 0)
                                ,

                                Placeholder::make('total_income')
                                    ->label('Total Income')
                                    ->content(function ($record) {
                                        $total = 0;

                                        if($record?->rooms) {
                                            foreach ($record->rooms as $room) {
                                                $total += $room->bookings?->sum('total_price');
                                            }
                                        }

                                        return 'Rp ' . number_format($total, 0, ',', '.');
                                    })
                                    ->disabled()
                                    ->columnSpan(2),
                            ]),
                    ])
                    ->columnSpan(1)
                    ->columns(2),





            ])
            ->columns(3);
    }
}
