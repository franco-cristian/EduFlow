// tailwind.config.js
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Livewire/**/*.php",
    "./app/View/Components/**/*.php"
  ],
  presets: [
    require('@tailwindcss/vite/preset')
  ],
  theme: {
    extend: {
      colors: {
        'education-primary': '#4361ee',
        'education-secondary': '#3f37c9',
        'education-light': '#f0f7ff',
        'education-dark': '#1e2b58',
      },
      animation: {
        'bounce-slow': 'bounce 3s infinite',
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}