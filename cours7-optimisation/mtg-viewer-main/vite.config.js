import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [vue()],
    root: './assets',
    base: '/build/',
    server: {
        port: 3000,
    },
    envDir: '../',
    build: {
        manifest: true,
        assetsDir: '',
        outDir: '../public/build',
        rollupOptions: {
            input: {
                'app.js': './assets/app.js',
            },
        },
    },
});
