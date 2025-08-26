import { defineConfig } from 'vite'
import { svelte } from '@sveltejs/vite-plugin-svelte'
import { resolve } from 'path'
import { fileURLToPath, URL } from 'node:url'
import autoprefixer from 'autoprefixer'

const __dirname = fileURLToPath(new URL('.', import.meta.url))

export default defineConfig({
  plugins: [svelte()],
  publicDir: 'fonts',
  build: {
    outDir: '../../../public/assets/svelte',
    emptyOutDir: true,
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'src/main.js')
      },
      output: {
        entryFileNames: '[name].js',
        chunkFileNames: '[name].js',
        assetFileNames: '[name].[ext]'
      }
    }
  },
  css: {
    postcss: {
      plugins: [
        autoprefixer()
      ]
    }
  },
  server: {
    port: 5173,
    host: true
  }
})
