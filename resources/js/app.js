import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import '../css/app.css'
import { InertiaProgress } from '@inertiajs/progress'
import { ZiggyVue } from 'ziggy'
import Toaster from "@meforma/vue-toaster";
import PrimeVue from 'primevue/config';
import 'primevue/resources/themes/lara-light-green/theme.css'
import ToastService from 'primevue/toastservice';


InertiaProgress.init({
  delay: 0,
  color: '#29d',
  includeCSS: true,
  showSpinner: true,
})

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
    .use(ZiggyVue)
    .use(Toaster)
    .use(PrimeVue, { unstyled: true, 
    
    })

      .use(plugin)
      .mount(el)
  },
})