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
<<<<<<< HEAD
            host: '7770-181-164-169-75.ngrok-free.ap'  // ACA SE CAMBIA CON EL LINK DEL NGROK
=======
            host: '121-200-127-44-229.ngrok-free.app'  // ACA SE CAMBIA CON EL LINK DEL NGROK
>>>>>>> 1d32e61a97f6fe10aa0305f4f0a5ca5f1e11a34a
        }
    }
});
