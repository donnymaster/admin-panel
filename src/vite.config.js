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
                'resources/js/pages/createCategoryPage.js',
                'resources/js/pages/createProductPage.js',
                'resources/js/pages/applicationPage.js',
                'resources/js/pages/updateCategoryProduct.js',
                'resources/js/pages/usersPage.js',
                'resources/js/pages/productReviewPage.js',
                'resources/js/pages/promocodePage.js',
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
