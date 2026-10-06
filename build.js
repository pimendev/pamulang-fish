import { execSync } from 'child_process';
import fs from 'fs';

console.log('Building Vite assets...');
execSync('npx vite build', { stdio: 'inherit' });

console.log('Syncing public assets to dist for Vercel...');
if (!fs.existsSync('dist')) {
    fs.mkdirSync('dist', { recursive: true });
}
fs.cpSync('public', 'dist', { recursive: true });

// Remove index.php from dist so Vercel passes dynamic routes to api/index.php
if (fs.existsSync('dist/index.php')) {
    fs.unlinkSync('dist/index.php');
}

console.log('Build complete! Output directory "dist" is ready.');
