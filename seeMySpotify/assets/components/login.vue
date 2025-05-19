<template>
  <div class="d-flex flex-column justify-content-center align-items-center vh-100 text-center">
    <button @click="loginWithSpotify">See My Spotify</button>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'login',
  methods: {
    loginWithSpotify() {
      window.location.href = '/spotify/login'; // Symfony backend route
    }
  }
});
</script>

