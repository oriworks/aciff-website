/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            spacing: {
                18: "4.5rem",
            },
            colors: {
                twitter: "#1da1f2",
                facebook: "#1877F2",
                linkedIn: "#0a66c2",
                aciff: "#485d71",
            },
            backgroundColor: (theme) => ({
                ...theme("colors"),
                secondary: "#222",
            }),
            textColor: (theme) => ({
                ...theme("colors"),
                primary: "#3490dc",
                secondary: "rgba(255, 255, 255, 0.7)",
            }),
            gridTemplateColumns: {
                table: "auto 1fr",
            },
        },
    },
    variants: {
        extend: {
            display: ["group-hover"],
        },
    },
    corePlugins: {
        container: false,
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/aspect-ratio"),
        function ({ addComponents }) {
            addComponents({
                ".container": {
                    width: "100%",
                    // marginLeft: 'auto',
                    // marginRight: 'auto',
                    // paddingLeft: '2rem',
                    // paddingRight: '2rem',
                    "@screen sm": {
                        maxWidth: "640px",
                    },
                    "@screen md": {
                        maxWidth: "768px",
                    },
                    "@screen lg": {
                        maxWidth: "1024px",
                    },
                    "@screen xl": {
                        maxWidth: "1280px",
                    },
                },
            });
        },
    ],
}

