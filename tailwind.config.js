import defaultTheme from 'tailwindcss/defaultTheme';
<<<<<<< HEAD
import forms from '@tailwindcss/forms';
=======
>>>>>>> b5b51b0bb45621dde3866f7afb008d296d778214

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
<<<<<<< HEAD
        './resources/views/**/*.blade.php',
    ],

=======
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
>>>>>>> b5b51b0bb45621dde3866f7afb008d296d778214
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
<<<<<<< HEAD

    plugins: [forms],
=======
    plugins: [],
>>>>>>> b5b51b0bb45621dde3866f7afb008d296d778214
};
