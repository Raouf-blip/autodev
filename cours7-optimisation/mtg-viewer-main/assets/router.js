import { createRouter, createWebHistory } from 'vue-router';

export const routes = [
    {
        name: 'index',
        path: '/',
        component: () => import('./pages/HomePage.vue'),
    },
    {
        name: 'all-cards',
        path: '/card/all',
        component: () => import('./pages/AllCardsPage.vue'),
    },
    {
        name: 'get-card',
        path: '/card/:uuid',
        component: () => import('./pages/CardPage.vue'),
    },
    {
        name: 'search-cards',
        path: '/search',
        component: () => import('./pages/SearchPage.vue'),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
