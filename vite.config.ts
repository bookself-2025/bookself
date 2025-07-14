import tailwindcss from '@tailwindcss/vite'
import react from '@vitejs/plugin-react-swc'
import path from 'path'
import {defineConfig} from 'vite'
import {tanstackRouter} from '@tanstack/router-plugin/vite'
import mkcert from 'vite-plugin-mkcert'

// https://vite.dev/config/
export default defineConfig({
    build: {
        emptyOutDir: true,
        manifest: true,
        modulePreload: {
            polyfill: true,
        },
        outDir: './dist',
        rollupOptions: {
            input: [
                './src/v1/app.tsx',
            ],
        },
    },
    publicDir: false,
    plugins: [
        // Please make sure that '@tanstack/router-plugin' is passed before '@vitejs/plugin-react'
        tanstackRouter({
            target: 'react',
            autoCodeSplitting: true,
            // File-based router setup
            routesDirectory: './src/v1/routes',
            generatedRouteTree: './src/v1/route-tree.gen.ts',
        }),
        react(),
        tailwindcss(),
        mkcert(),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './src'),
        },
    },
    server: {
        host: true,
        cors: {
            origin: '*',
        },
    },
})
