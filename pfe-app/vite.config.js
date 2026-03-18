import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/enseignant/dashboard.css',
                'resources/js/app.js',
                'resources/css/sidebar.css',
                'resources/js/sidebar.js',
                'resources/js/topbar.js',
                'resources/css/topbar.css'
            ],
            refresh: true,
        }),
    ],
});
