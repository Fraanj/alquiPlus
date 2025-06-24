import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';

export default defineConfig({
    base: process.env.ASSET_URL || '/',
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        https: true, // habilita HTTPS en el dev server
        host: '0.0.0.0', // o especifica la IP o dominio adecuado
        hmr: {
            host: 'localhost'  // ACA SE CAMBIA CON EL LINK DEL NGROK
        }
    }
});
