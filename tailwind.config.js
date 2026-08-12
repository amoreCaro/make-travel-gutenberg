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
      screens: {
        DEFAULT: '1800px',
      },
    },
    
    extend: {
      keyframes: {
        'video-banner-reveal': {
          to: { opacity: '1', transform: 'translateY(0)' },
        },
        'video-banner-fade-in': {
          to: { opacity: '1' },
        },
        'video-banner-scroll-bounce': {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(4px)' },
        },
      },
      animation: {
        'video-banner-reveal':
          'video-banner-reveal 0.9s cubic-bezier(0.22, 1, 0.36, 1) forwards',
        'video-banner-fade-in':
          'video-banner-fade-in 0.9s cubic-bezier(0.22, 1, 0.36, 1) forwards',
        'video-banner-scroll-bounce':
          'video-banner-scroll-bounce 1.8s ease-in-out infinite',
      },
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
