<?php

namespace App\Filament\Librarian\Resources\BookResource\Pages;

use App\Filament\Librarian\Resources\BookResource;
use App\Models\Admin;
use App\Models\Book;
use App\Models\Librarian;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateBook extends CreateRecord
{
    protected static string $resource = BookResource::class;

    protected function afterCreate(): void
    {

        /** @var Book $order */
        $book = $this->record;

        /** @var Librarian $user */
        $admins = Admin::query()->get();

        foreach ($admins as $admin) {
            Notification::make()
                ->title('New Book')
                ->icon('heroicon-o-book-open')
                ->body("Book {$book->title} has been created in library {$book->library?->name}")
                ->duration(10)
                ->sendToDatabase($admin);

            event(new DatabaseNotificationsSent($admin));
        }
    }

}
