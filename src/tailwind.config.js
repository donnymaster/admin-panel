/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    colors: {
        'theme-blue': '#9900FF',
        'theme-light-blue': 'rgba(103, 22, 151, 0.50)',
        'theme-red': '#FF3F3F',
        'theme-red-active': '#FF0000',
        'theme-green': '#8FDD41',
        'theme-green-active': '#42bf19',
        'theme-grey': 'rgba(30, 30, 30, 0.5)',
        'theme-badge-blue':'rgba(121, 148, 253, 0.80)',
        'white': 'rgb(255 255 255)',
        'black': 'rgb(0, 0, 0)',
        'red': 'red',

        'primary-color': 'rgba(153, 0, 255, 1)',
        'primary-color-light': 'rgba(103, 22, 151, 0.50)',
        'theme-red': '#FF3F3F',
        'theme-red-active': '#FF0000',
        'theme-green': '#8FDD41',
        'theme-green-active': '#42bf19',
        'theme-grey': 'rgba(30, 30, 30, 0.5)',
        'theme-badge-blue':'rgba(121, 148, 253, 0.80)',
        'white': 'rgb(255 255 255)',
        'black': 'rgb(0, 0, 0)',
        'red': 'red',
        /**
         * Dark theme
         */

        'primary-dark': '#06090E',
        'second-dark': '#152A3D',
        'third-dark': '#3A668B',
    },
    extend: {},
  },
  plugins: [],
  darkMode: "class",
}

