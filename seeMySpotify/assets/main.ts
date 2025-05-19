import { createApp } from 'vue';
import App from './app.vue';
import router from './router'; // assuming you created router.ts as before

createApp(App)
  .use(router)
  .mount('#app');
