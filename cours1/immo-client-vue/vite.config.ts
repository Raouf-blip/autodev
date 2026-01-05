/* eslint-disable no-undef */
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';


export default () => {
    return defineConfig({
        plugins: [vue()],

        server: {
            host: true,
            port: 3000
        },
    });
}