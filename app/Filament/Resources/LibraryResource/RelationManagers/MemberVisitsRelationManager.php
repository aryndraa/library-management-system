<?php

namespace App\Filament\Resources\LibraryResource\RelationManagers;

use App\Models\MemberVisit;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MemberVisitsRelationManager extends RelationManager
{
    protected static string $relationship = 'MemberVisits';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('member')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('member_id')
            ->columns([

                Tables\Columns\TextColumn::make('member.profile.first_name')
                    ->label('Name')
                    ->getStateUsing(function ($record) {
                        return $record->member->profile->first_name . ' ' . $record->member->profile->last_name;
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('member.email')
                    ->label('Email')
                    ->sortable(),


                Tables\Columns\TextColumn::make('visit_date')
                    ->dateTime()
                    ->sortable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('Period')
                    ->label('Period')
                    ->options([
                        'today' => 'Today',
                        'last_week' => 'Last Week',
                        'last_month' => 'Last Month',
                        'last_year' => 'Last Year',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!empty($data['value']) && !empty($data['created_at'])) {
                            return $query;
                        }

                        return match ($data['value'] ?? null) {
                            'today' => $query->whereDate('visit_date', Carbon::today()),
                            'last_week' => $query->whereBetween('visit_date', [Carbon::now()->subWeek(), Carbon::now()]),
                            'last_month' => $query->whereBetween('visit_date', [Carbon::now()->subMonth(), Carbon::now()]),
                            'last_year' => $query->whereBetween('visit_date', [Carbon::now()->subYear(), Carbon::now()]),
                            default => $query,
                        };
                    })
                    ->default('today'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
