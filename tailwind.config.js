/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/html/*.html",
    "./*.php",
    "./app/**/*.php",
    "../**/*.php",
    "./src/js/**/*.js",
    "./src/css/**/*.css"
  ],

  theme: {
    screens: {
      sm: '640px',
      md: '768px',
      lg: '1024px',
      xl: '1440px',
      '2xl': '1920px',
      '3xl': '2560px',
    },

    container: {
      center: true,
      padding: '1.25rem',
      screens: {
        lg: '1440px', // 👈 кастомний max-width
      },
    },

    extend: {
      colors: {
        gray: '#9395ABCC',
      },
      fontFamily: {
        roboto: ['Roboto', 'sans-serif'],
        sans: ['Roboto', 'ui-sans-serif', 'system-ui'],
      },
    },
  },

  plugins: [],
};
