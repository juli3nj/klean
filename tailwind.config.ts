// https://tailwindcss.com/docs/configuration
import type { Config } from 'tailwindcss';
import forms from '@tailwindcss/forms';

export default {
  content: [
    './app/**/*.php',
    './resources/**/*.{php,js,ts,tsx,vue}',
    './resources/views/**/*.php',
    './public/content/themes/radicle/index.php',
  ],
  theme: {
    extend:{
      fontSize :{
        '5xl' : ['3rem', '1.33em'],
      },
    },
    colors: {
      inherit: 'inherit',
      current: 'currentColor',
      transparent: 'transparent',
      black: '#000',
      white: '#fff',
      primary: {
        600: '#606060',
        1000: '#141414',
      },
      secondary: {
        300: '#FABC43',
        600: '#F08825',
        800: '#ED7218',
        1000: '#E8680D',
      },
      "alt-white": '#FFFDFD'
    },
    fontFamily: {
      'raleway': ['Raleway', 'sans-serif'],
      'afacad': ['Afacad', 'sans-serif'],
    },
  },
  plugins: [
    forms,
  ],
} satisfies Config;
