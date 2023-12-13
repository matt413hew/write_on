/** @type {import('tailwindcss').Config} */
export default {
  purge: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  darkMode: false, // or 'media' or 'class'
  content: [],
   safelist: [
    {
      pattern: /max-w-(xs|sm|md|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl)/
    },
    {
      pattern: /bg-(slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-500/

    },
    {
      pattern: /bg-(slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-600/
    },
    {
      pattern: /bg-(slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-400/
    },
    {
      pattern: /bg-(slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-800/
    },
    {
      pattern: /bg-(slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-700/
    },
    {
      pattern: /p-(0|1|2|3|4|5|6|7|8)/
    }
  ],
  theme: {
    fontFamily: {
      sans: [
        "Lexend",
      ]
    },
    extend: {},
  },
  variants: {
    extend: {},
  },
   plugins: [require("daisyui")],
}

