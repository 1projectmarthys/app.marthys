/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#3490dc',
        secondary: '#6574cd',
        success: '#38c172',
        danger: '#e3342f',
        warning: '#f6993f',
      },
    },
  },
  plugins: [],
}