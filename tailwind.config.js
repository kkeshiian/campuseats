/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.php",
    "./*.{php,html,js}",
    "./components/**/*.{php,html,js}",
    "./pages/**/*.{php,html,js}",
    "./src/**/*.{php,html,js}",
    "./api/**/*.{php,html,js}",
    "./controllers/**/*.{php,html,js}",
    "./partials/**/*.{php,html,js}",
  ],
  theme: {
    extend: {
      colors: {
        primary: "#6b7280", 
        accent: "#4caf50", 
        background: "#f9fafb",
        kuning: "#FFB43B",
      },
      fontFamily: {
        poppins: ["Poppins", "sans-serif"],
      },
    },
  },
  plugins: [require("daisyui")],
};
