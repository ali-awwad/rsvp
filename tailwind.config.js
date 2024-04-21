/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.jsx",
  ],
  theme: {
    extend: {
        colors: {
            'rsvp': {
                'darkblue':'#1f4e8a',
                'purple':'#5c3385',
                'lightyellow':'#eeeae1',
            }
        }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}

