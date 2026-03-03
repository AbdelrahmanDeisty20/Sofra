const { defineConfig } = require("vite");
const laravel = require("laravel-vite-plugin").default;
const react = require("@vitejs/plugin-react").default;
const tailwindcss = require("@tailwindcss/vite").default;

module.exports = defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.jsx"],
            refresh: true,
        }),
        react(),
        tailwindcss(),
    ],
});
