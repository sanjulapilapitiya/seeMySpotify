import { createRouter, createWebHistory } from 'vue-router';
import SpotifyLogin from './components/login.vue';
import SpotifyDashboard from './components/spotifyDashboard.vue';

const routes = [
    { path: '/spotify-dashboard', component: SpotifyDashboard },
    { path: '/', component: SpotifyLogin },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
