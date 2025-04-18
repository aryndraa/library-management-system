/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
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
