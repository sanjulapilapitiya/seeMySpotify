<template>
  <div>
    <button @click="loginWithSpotify">Login with Spotify</button>
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

