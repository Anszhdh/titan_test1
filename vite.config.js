import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        
    ],
    server: {
        host: '192.168.1.87', // Use your local network IP
        port: 5173, // Port for Vite
        hmr: {
            host: '192.168.1.87', // HMR (Hot Module Replacement) should also use your network IP
        },
    },
});
