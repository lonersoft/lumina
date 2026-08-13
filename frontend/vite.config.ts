import { fileURLToPath, URL } from 'node:url';

import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import oxlintPlugin from 'vite-plugin-oxlint';
import ViteYaml from '@modyfi/vite-plugin-yaml';
import tailwindcss from '@tailwindcss/vite';

// https://vite.dev/config/
const proxyTarget = process.env.VITE_PROXY_TARGET || 'http://backend:80';

export default defineConfig({
    plugins: [
        ViteYaml({
            onWarning: (warning) => {
                console.warn('[Lumina/YML⚠️] Yaml parser warning: ' + warning);
            },
        }),
        vue(),
        tailwindcss(),
        oxlintPlugin(),
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./src', import.meta.url)),
        },
    },
    server: {
        host: '0.0.0.0',
        allowedHosts: true,
        proxy: {
            '/api': {
                target: proxyTarget,
                changeOrigin: true,
                secure: false,
                rewrite: (path) => path,
            },
            '/attachments': {
                target: proxyTarget,
                changeOrigin: true,
                secure: false,
                rewrite: (path) => path,
            },
            '/i/': {
                target: proxyTarget,
                changeOrigin: true,
                secure: false,
                rewrite: (path) => path,
            },
        },
    },
    build: {
        sourcemap: false,    
        // Increase chunk size warning limit
        chunkSizeWarningLimit: 1000,
    },
    optimizeDeps: {
        include: [
            'vue', 
            'vue-router', 
            'pinia', 
            'vue-i18n', 
            'vue-sweetalert2',
            'lucide-vue-next',
            'date-fns'
        ],
        exclude: [],
    },
    cacheDir: '.vite',
});
