import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/Livewire/**/*.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                green: {
                    primary: '#2e9e5b',
                    dark: '#1a6e3c',
                    light: '#f0faf4',
                    border: '#c6efd7',
                },
                appWhite: '#ffffff',
                text: {
                    primary: '#1a1a1a',
                    secondary: '#6b7280',
                },
                alert: {
                    red: '#e74c3c',
                    amber: '#f39c12',
                }
            },
            boxShadow: {
                hover: '0 1px 4px rgba(0,0,0,0.07)',
            }
        },
    },
    plugins: [forms, typography],
};