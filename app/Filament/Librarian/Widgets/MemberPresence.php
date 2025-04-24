<?php

namespace App\Filament\Librarian\Widgets;

use App\Models\MemberVisit;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class MemberPresence extends BaseWidget
{

    protected int | string | array $columnSpan = 4;

    protected static ?int $sort = 7;

    public function table(Table $table): Table
    {
        return $table
            ->query(
               MemberVisit::query()
                    ->where('library_id', auth()->user()->library_id)
                    ->whereDate('visit_date', today())
            )
            ->columns([
                SpatieMediaLibraryImageColumn::make('member.member')
                    ->label('Picture')
                    ->collection('member')
                    ->height(50)
                    ->width(50)
                    ->rounded(),

                TextColumn::make('member.profile.first_name')
                    ->label('Name')
                    ->getStateUsing(function ($record) {
                        return $record->member->profile->first_name . ' ' . $record->member->profile->last_name;
                    }),

                TextColumn::make('member.email')
                    ->label('Email'),

                TextColumn::make('visit_date')
                    ->label('Visit Time')
                    ->time()
            ]);
    }
}
