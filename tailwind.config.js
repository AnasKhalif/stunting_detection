import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                "hero-ilustration": "url('/img/hero-ilustration.png')", // Sesuaikan path gambar kamu
            },
            boxShadow: {
                "shadow-card": "10px 10px 0px 0px rgb(21 128 61)",
            },
        },
    },

    plugins: [forms],
};
