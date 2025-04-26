<?php

namespace App\Providers\Filament;

use App\Filament\Clusters\AccountSettings;
use App\Filament\Librarian\Pages\Dashboard;
use App\Filament\Librarian\Pages\LibraryDetail;
use App\Filament\Librarian\Pages\Profile;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class LibrarianPanelProvider extends PanelProvider
{

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('librarian')
            ->sidebarCollapsibleOnDesktop()
            ->path('librarian')
            ->login()
            ->userMenuItems([
                MenuItem::make()
                    ->label('Account Settings')
                    ->url(fn (): string => AccountSettings::getUrl())
                    ->icon('heroicon-o-cog-8-tooth'),
                MenuItem::make()
                    ->label('Library Detail')
                    ->url(fn (): string => LibraryDetail::getUrl())
                    ->icon('heroicon-o-building-library'),
            ])
            ->spa()
            ->colors([
                'primary' => "#6678C3",
            ])
            ->font('"Outfit", sans-serif')
            ->brandLogo(fn () => view('filament.app.logo', [
                'title' => 'Librarian',
            ]))
            ->discoverClusters(app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->discoverResources(in: app_path('Filament/Librarian/Resources'), for: 'App\\Filament\\Librarian\\Resources')
            ->discoverPages(in: app_path('Filament/Librarian/Pages'), for: 'App\\Filament\\Librarian\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Librarian/Widgets'), for: 'App\\Filament\\Librarian\\Widgets')
            ->widgets([
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->authGuard('librarian')
            ->viteTheme('resources/css/filament/librarian/theme.css')
            ->darkMode(false);
    }
}
