<?php

namespace App\Filament\Clusters\AccountSettings\Resources\ProfileSettingsResource\Widgets;

use App\Models\Library;
use Filament\Widgets\Widget;

class LibraryInfo extends Widget
{
    protected static string $view = 'filament.clusters.account-settings.resources.profile-settings-resource.widgets.library-info';

    public ?int $libraryId = null;

    public function mount(): void
    {
        $this->libraryId = auth()->user()->library_id;
    }

    public function getLibraryInfo()
    {
        return Library::find($this->libraryId);
    }
}
