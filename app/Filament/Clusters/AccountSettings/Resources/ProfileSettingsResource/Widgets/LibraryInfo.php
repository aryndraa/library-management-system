<?php

namespace App\Filament\Clusters\AccountSettings\Resources\ProfileSettingsResource\Widgets;

use App\Filament\Librarian\Pages\LibraryDetail;
use App\Filament\Resources\BookResource;
use App\Models\Library;
use Filament\Actions\Action;
use Filament\Widgets\Widget;

class LibraryInfo extends Widget
{
    protected static string $view = 'filament.clusters.account-settings.resources.profile-settings-resource.widgets.library-info';


    protected int | string | array $columnSpan = 2;


    public function getLibraryInfo()
    {
        return Library::find(auth()->user()->library_id);
    }

    public function getActions(): Action
    {
        return Action::make('View Library Detail')
                ->icon('heroicon-o-eye')
                ->url(fn () => LibraryDetail::getUrl());
    }

}
