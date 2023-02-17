import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],

    build: {
        rollupOptions: {
            output: {
                // chunkFileNames: 'assets/js/[name].js',
                // entryFileNames: 'assets/js/[name].js',
                entryFileNames: `assets/[name]-[hash].js`,
                chunkFileNames: `assets/[name]-[hash].js`,
                assetFileNames: `assets/[name]-[hash].[ext]`,

                // assetFileNames: ({ name }) => {
                //     if (/\.(gif|jpe?g|png|svg)$/.test(name ?? "")) {
                //         return "assets/images/[name]-[hash][extname]";
                //     }

                //     if (/\.css$/.test(name ?? "")) {
                //         return "assets/css/[name]-[hash][extname]";
                //     }

                //     // default value
                //     // ref: https://rollupjs.org/guide/en/#outputassetfilenames
                //     return "assets/[name]-[hash][extname]";
                // },
            },
        },
    },
});
