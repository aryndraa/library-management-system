<?php

    namespace App\Filament\Librarian\Resources\BookResource\Pages;

    use App\Filament\Librarian\Resources\BookResource;
    use Filament\Actions;
    use Filament\Notifications\Notification;
    use Filament\Resources\Pages\EditRecord;

    class EditBook extends EditRecord
    {
        protected static string $resource = BookResource::class;

        protected function getHeaderActions(): array
        {
            return [
                Actions\DeleteAction::make()
                    ->before(function (Actions\DeleteAction $action) {
                        if ($this->record->borrowings()->whereNot('status', 'returned')->exists()) {
                            Notification::make()
                                ->title('Buku tidak bisa dihapus')
                                ->body('Masih ada peminjam yang belum mengembalikan buku ini.')
                                ->danger()
                                ->send();

                            $action->cancel();
                        }
                    }),
            ];
        }
    }
