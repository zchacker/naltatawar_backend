import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors:{
                transparent: 'transparent',
                current: 'currentColor',        
                'primary' : '#6A5036',
                'secondary': '#B29877',
                'light-secondary' : '#EDE6D9',
                'cta': '#FCAC20'               
              },
            fontFamily: {
                sans: ['Cairo', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
