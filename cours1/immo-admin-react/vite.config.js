/* eslint-disable no-undef */
import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';


export default () => {
    return defineConfig({
        plugins: [react()],
        server: {
          host: true,
          port: 3000
      }
    });
}