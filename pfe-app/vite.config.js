import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Shared
                'resources/css/app.css',
                'resources/js/app.js',
                // Admin
                'resources/css/admin/admin.css',
                'resources/js/admin/admin.js',
                // Chef
                'resources/css/chef/chef.css',
                // Enseignant
                'resources/css/enseignant/enseignant.css',
                'resources/js/enseignant/enseignant.js',
                // Étudiant
                'resources/css/etudiant/etudiant.css',
            ],
            refresh: true,
        }),
    ],
});
