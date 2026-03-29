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
        brand: {
          cream: '#FFF5F7',
          blush: '#FFE4EC',
          rose: '#D4788A',
          'rose-dark': '#A8485C',
          text: '#2D1A1F',
          muted: '#9E7080',
        }
      },
      fontFamily: {
        alice: ["Alice"],
        marck: ["MarckScript"],
        amatic: ["AmaticSC"],
        caveat: ["Caveat"],
        badscript: ["BadScript"],
        kurale: ["Kurale"],
      },
      keyframes: {
        'zoom-in': {
          "from": { transform: "scale(0.4)" },
          "to": { transform: "scale(1)" }
        },
        'zoom-out': {
          "from": { transform: "scale(1)" },
          "to": { transform: "scale(0.4)" }
        },
      },
      animation: {
        'zoom-in': 'zoom-in 0.5s ease-in-out both',
        'zoom-out': 'zoom-out 0.5s ease-in-out both',
      }
    },
  },
  plugins: [],
}
