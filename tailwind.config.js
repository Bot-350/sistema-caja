import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                malba: {
                    'rose-pale': '#E8C1C5',
                    'rose-dark': '#D4989F',
                    'gray-light': '#F9F7F7',
                    'gray-lighter': '#F3F1F1',
                    'gray-dark': '#4A4A4A',
                    'gray-medium': '#8B8B8B',
                },
            },
            boxShadow: {
                'elegant': '0 1px 3px rgba(0, 0, 0, 0.08), 0 2px 6px rgba(0, 0, 0, 0.06)',
                'elegant-lg': '0 4px 12px rgba(0, 0, 0, 0.08), 0 2px 8px rgba(0, 0, 0, 0.06)',
            },
        },
    },

    plugins: [forms],
};
