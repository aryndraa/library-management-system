<?php

namespace App\Filament\Clusters\Librarian\Resources;

use App\Filament\Clusters\Librarian;
use App\Filament\Clusters\Librarian\Resources\LibrarianAbsentReportResource\Pages;
use App\Filament\Clusters\Librarian\Resources\LibrarianAbsentReportResource\RelationManagers;
use App\Models\LibrarianAbsent;
use App\Models\LibrarianAbsentReport;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LibrarianAbsentReportResource extends Resource
{
    protected static ?string $model = LibrarianAbsent::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static ?int $navigationSort = 3;

    protected static ?string $label = "Report";

    protected static ?string $cluster = Librarian::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('librarian.profile.first_name')
                    ->label('Name')
                    ->getStateUsing(function ($record) {
                        return $record->librarian->profile->first_name . ' ' . $record->librarian->profile->last_name;
                    })
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(30)
                    ->default("-///-"),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y')
                    ->sortable(),
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
                            'today' => $query->whereDate('created_at', Carbon::today()),
                            'last_week' => $query->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()]),
                            'last_month' => $query->whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()]),
                            'last_year' => $query->whereBetween('created_at', [Carbon::now()->subYear(), Carbon::now()]),
                            default => $query,
                        };
                    })
                    ->default('today'),

//                Tables\Filters\Filter::make('created_at')
//                    ->form([
//                        Forms\Components\DatePicker::make('created_at')
//                            ->placeholder('Pilih tanggal')
//                            ->reactive(),
//                    ])
//                    ->query(function (Builder $query, array $data): Builder {
//                        if (!empty($data['period']) && !empty($data['created_at'])) {
//                            return $query;
//                        }
//
//                        return $query->when(
//                            isset($data['created_at']) && !empty($data['created_at']),
//                            fn (Builder $query) => $query->whereDate('created_at', '=', $data['created_at']),
//                        );
//                    })
//                    ->label('Report Date')
//                    ->default(Carbon::now()->format('Y-m-d'))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLibrarianAbsentReports::route('/'),
            'create' => Pages\CreateLibrarianAbsentReport::route('/create'),
            'edit' => Pages\EditLibrarianAbsentReport::route('/{record}/edit'),
        ];
    }
}
