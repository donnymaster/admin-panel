import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/pages/reviewPage.js',
                'resources/js/pages/settingPage.js',
                'resources/js/pages/categoryPage.js',
                'resources/js/pages/boardPage.js',
                'resources/js/pages/statisticPage.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        hmr: {
            host: 'localhost',
        },
      }
});
