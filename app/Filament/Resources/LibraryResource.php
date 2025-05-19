<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LibraryResource\Pages;
use App\Filament\Resources\LibraryResource\RelationManagers;
use App\Filament\Resources\LibraryResource\Widgets\LibrarianQrCode;
use App\Models\Library;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LibraryResource extends Resource
{
    protected static ?string $model = Library::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = "Library Operations";

    public static function form(Form $form): Form
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

                        Section::make('Librarian Absent')
                            ->schema([

                                Placeholder::make('qr_code')
                                    ->label('')
                                    ->content(function ($record) {
                                        $qr = QrCode::size(105)->generate(url('/librarian/presence/' . $record->id));
                                        return new HtmlString($qr);
                                    })

                            ])
                            ->columnSpan(1),

                        Section::make('Member Attendance')
                            ->schema([

                                Placeholder::make('qr_code')
                                    ->label('')
                                    ->content(function ($record) {
                                        $qr = QrCode::size(105)->generate(url('http://library-app.test/attendance/' . $record->id));
                                        return new HtmlString($qr);
                                    })
                            ])
                            ->columnSpan(1)
                    ])
                    ->columnSpan(1)
                    ->columns(2),





            ])
            ->columns(3);
    }

    public static function view(ViewRecord $view)
    {
        return $view->view('filament.resources.library-gallery');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('library')
                    ->label('Picture')
                    ->collection('library')
                    ->height(50)
                    ->width(50)
                    ->limit(1),

                TextColumn::make('name')
                    ->label('Library')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->limit(20),

                TextColumn::make('phone'),

                TextColumn::make("books_count")
                    ->label('Total Books')
                    ->counts('books')
                    ->sortable(),

                TextColumn::make("rooms_count")
                    ->label('Total Rooms')
                    ->counts('rooms')
                    ->sortable(),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\BooksRelationManager::class,
            RelationManagers\LibrariansRelationManager::class,
            RelationManagers\RoomsRelationManager::class,
            RelationManagers\MemberVisitsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLibraries::route('/'),
            'create' => Pages\CreateLibrary::route('/create'),
            'view' => Pages\ViewLibrary::route('/{record}'),
            'edit' => Pages\EditLibrary::route('/{record}/edit'),
        ];
    }

    protected static function savePicture(?Model $record, UploadedFile $file): void
    {
        if (!$record) return;

        if ($record->picture) {
            Storage::disk('public')->delete($record->picture->file_path);
            $record->picture->delete();
        }

        $filePath = $file->store('library/', 'public');

        $record->picture()->create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => $file->getMimeType(),
        ]);
    }

}
