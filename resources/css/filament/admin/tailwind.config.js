import preset from "../../../../vendor/filament/filament/tailwind.config.preset";

export default {
    presets: [preset],
    content: [
        './app/Filament/C:\laragon\www\library-app\app\Filament\Clusters\AccountSettings\**/*.php',
        './resources/views/filament/c:\laragon\www\library-app\app\-filament\-clusters\-account-settings\**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extends: {
            colors: {
                primary: {
                    100: "#6678C3",
                    200: "#4D5FB5",
                    300: "#37447D",
                    400: "#435085",
                },
            },
        },
    },
};
