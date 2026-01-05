import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'


export default defineConfig({
    root: './src',
    base: '/',
    plugins: [vue()],
    server: {
        port: 3000,
        open: true,
    },
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./src', import.meta.url))
        }
    },
    build: {
        assetsDir: '',
        outDir: '../public/build/',
        rollupOptions: {
            input: {
                'main.js': './assets/main.js',
            }
        }
    },
});