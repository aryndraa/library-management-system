<?php

namespace App\Livewire;

use App\Models\LibrarianShift;
use Filament\Facades\Filament;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LibrarianShiftTable extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                LibrarianShift::query()
                    ->where('librarian_id', Filament::auth()->id())

            )
            ->columns([
                TextColumn::make('day')
                    ->label('Day'),

                TextColumn::make('clock_in')
                    ->label('Clock In'),

                TextColumn::make('clock_out')
                    ->label('Clock Out'),

            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render(): View
    {
        return view('livewire.librarian-shift-table');
    }
}
