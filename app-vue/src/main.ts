import { createApp } from 'vue'
import './ui/assets/css/tailwind.css'
import App from './App.vue'
import router from './routes';
import pinia from './config/plugins/pinia';
import Notifications from '@kyvg/vue3-notification';

const app = createApp(App)
app.use(router)
app.use(pinia)
app.use(Notifications)
app.mount('#app')
