import { defineConfig } from 'vite';
import reactRefresh from '@vitejs/plugin-react-refresh'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [reactRefresh()],

  build: {
    manifest: true,
    assetsDir: '',
    outDir: '../public/assets/',
    rollupOptions: {
      output: {
        manualChunks: undefined // On ne veut pas créer un fichier vendors, car on n'a ici qu'un point d'entré
      },
      input: {
        input : './assets/main.js'
      }
    }
  }
});