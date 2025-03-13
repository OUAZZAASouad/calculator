import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';
import ToastService from 'primevue/toastservice';


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        // Define the glob imports
        const modulePages = import.meta.glob<DefineComponent>('../../app/Modules/**/resources/js/pages/*.vue');
        const defaultPages = import.meta.glob<DefineComponent>('./pages/**/*.vue');
    
        // Check if the name follows the "Module::Page" pattern
        if (name.includes('::')) {
          const [module, page] = name.split('::');
          const path = `../../app/Modules/${module}/resources/js/pages/${page}.vue`;
    
          if (modulePages[path]) {
            return modulePages[path](); // Ensure it returns a promise
          } else {
            console.error(`Module page not found: ${path}`);
          }
        }
    
        // Default to resolving from the Pages directory
        const path = `./pages/${name}.vue`;
        if (defaultPages[path]) {
          return defaultPages[path](); // Ensure it returns a promise
        } else {
          console.error(`Default page not found: ${path}`);
        }
    
        throw new Error(`Page "${name}" not found.`);
      },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                theme: {
                    preset: Aura
                }
            })
            .use(ToastService)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
