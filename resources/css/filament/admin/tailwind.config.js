import preset from "../../../../vendor/filament/filament/tailwind.config.preset";

export default {
    presets: [preset],
    content: [
        "./app/Filament/C:laragonwwwlibrary-appappFilamentClustersBookBorrowing**/*.php",
        "./resources/**/*.blade.php",
        "./resources/views/filament/c:laragonwwwlibrary-appapp-filament-clusters-book-borrowing**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
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
