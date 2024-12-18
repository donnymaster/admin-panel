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
                'resources/js/pages/productPage.js',
                'resources/js/pages/ordersPage.js',
                'resources/js/pages/createVariantPage.js',
                'resources/js/pages/productsPage.js',
                'resources/js/pages/updateVariantProduct.js',
                'resources/js/pages/orderPage.js',
                'resources/js/pages/createNewPage.js',
                'resources/js/pages/dataExchangePage.js',
                'resources/js/pages/propertiesPage.js',
                'resources/js/pages/articlesPage.js',
                'resources/js/pages/createArticlePage.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        origin: 'http://192.168.1.101:5173',
        hmr: {
            host: '192.168.1.101',
        },
      }
});
