/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        alice: ["Alice"],
        marck: ["MarckScript"],
        amatic: ["AmaticSC"],
        caveat: ["Caveat"],
        badscript: ["BadScript"],
        kurale: ["Kurale"],
      },
    },
  },
  plugins: [],
}
