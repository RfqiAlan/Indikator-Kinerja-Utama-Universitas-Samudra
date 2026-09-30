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
                semantic: {
                    bg: 'var(--color-bg)',
                    surface: 'var(--color-surface)',
                    'surface-elevated': 'var(--color-surface-elevated)',
                    text: 'var(--color-text)',
                    'text-muted': 'var(--color-text-muted)',
                    border: 'var(--color-border)',
                    primary: 'var(--color-primary)',
                    'primary-text': 'var(--color-primary-text)',
                }
            }
        },
    },

    plugins: [forms],
};
