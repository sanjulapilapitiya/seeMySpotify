import { createApp } from 'vue';
import App from './app.vue';
import router from './router';
import 'bootstrap/dist/css/bootstrap.min.css';
import './styles/app.css';

createApp(App)
  .use(router)
  .mount('#app');
