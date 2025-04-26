/** @type {import('tailwindcss').Config} */
import preset from './vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        "./resources/**/*.blade.php",
        './resources/views/filament/librarian/**/*.blade.php',
        './resources/views/librarian/**/*.blade.php',
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/filament/**/*.blade.php",
    ],
    theme: {
        extend: {
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
    plugins: [],
};
