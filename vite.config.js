import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

import { cloudflare } from "@cloudflare/vite-plugin";

export default defineConfig({
    plugins: [// <-- add this for JSX support
    react(), laravel({
        input: ['resources/css/app.css', 'resources/js/app.jsx'],
        refresh: true,
    }), cloudflare()],
});