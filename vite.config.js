import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/js/app.js'],
      refresh: true,
    }),
    vue(),
  ],
  publicDir: false,
  build: {
    manifest: true,
    outDir: 'public/build',
    assetsDir: 'assets',
    rollupOptions: {
      input: path.resolve(__dirname, 'resources/js/app.js'),
    },
  },
});
