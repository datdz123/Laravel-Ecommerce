module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: "class", // false or 'media' or 'class'
    theme: {
        extend: {
            screens: {
                'ipad': '820px', // breakpoint mới cho iPad Air
            },

            colors: {
                'body-bg': '#ffffff',
                'primary': '#003A70',
                'green': '#8CBA41',
                'pink': '#ED76B7',
                'body-text': '#464646',

            },
            fontFamily: {
                'sans': ['DINRoundOT', 'sans-serif'],
            },
            fontSize: {
                'base': '16px',
            },
            lineHeight: {
                'base': '25.84px',
            },
        },
        typography: (theme) => ({
            DEFAULT: {
                css: {
                    color: theme('colors.gray.700'),
                    a: {
                        color: theme('colors.blue.500'),
                        '&:hover': {
                            color: theme('colors.blue.700'),
                        },
                    },
                },
            },
        }),
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
