import { defineConfig } from 'vite';

export default defineConfig({
    root: './assets',
    base: '/build/',
    server: {
        host: '0.0.0.0',
        port: 3000
    },
    build: {
        manifest: true,
        assetsDir: '',
        outDir: '../public/build/',
        emptyOutDir: true,
        rollupOptions: {
            input: {
                'main': './assets/main.js',
            }
        }
    }
});