<template>
  <div>
    <h1>Your Spotify Dashboard</h1>
    
    <section>
      <h2>Profile</h2>
      <p v-if="profile">Logged in as: {{ profile.display_name }}</p>
    </section>

    <section>
      <h2>Top 5 Tracks</h2>
      <ul>
        <li v-for="track in topTracks" :key="track">
          {{ track.name }} by {{ track.artists[0].name }}
        </li>
      </ul>
    </section>

    <!-- Add more sections here for playlists, recently played, etc. -->
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';

export default defineComponent({
  name: 'spotifyDashboard',
  setup() {
    const route = useRoute();
    const accessToken = route.query.s;

    const profile = ref(null);
    const topTracks = ref([]);

    onMounted(async () => {
      if (!accessToken) {
        alert('Access token missing!');
        return;
      }

      // Fetch profile
      const profileResponse = await fetch('https://api.spotify.com/v1/me', {
        headers: { Authorization: `Bearer ${accessToken}` }
      });
      if (profileResponse.ok) {
        profile.value = await profileResponse.json();
      }

      // Fetch top tracks
      const topTracksResponse = await fetch('https://api.spotify.com/v1/me/top/tracks?limit=5', {
        headers: { Authorization: `Bearer ${accessToken}` }
      });
      if (topTracksResponse.ok) {
        const data = await topTracksResponse.json();
        topTracks.value = data.items;
      }
    });

    return { profile, topTracks };
  }
});
</script>
