<template>
  <div>
    <h1>Your Spotify Dashboard</h1>
    
    <section class="border-green">
      <h2>Profile</h2>
      <div v-if="profile">
        <p>Logged in as: {{ profile.display_name }}</p>
        <p>Followers: {{ profile.followers.total }}</p>
      </div>
    </section>

    <section class="border-green">
      <h2>Top 5 Tracks</h2>
        <ol 
          style="
            display: flex; 
            justify-content: center; 
            gap: 2rem; 
            list-style-type: decimal;
            flex-wrap: wrap; /* if you want to wrap on smaller screens */
            padding-left: 0px;
          "
        >
        <li v-for="(track, index) in topTracks" :key="track.id" style="margin-bottom: 1rem;">
          <div class="card" style="width: 18rem; background-color: #212121;">
            <img :src="track.album.images[0]?.url" class="card-img-top" alt="album cover">
            <h2>
              <div style="color: #1DB954; padding-bottom: 15px;">#{{ index + 1 }}</div>
              <span style="padding: 10px 14px;">{{ track.name.length > 20 ? track.name.slice(0, 20) + '...' : track.name }}</span>
              <p class="card-text">by {{ track.artists[0].name }}</p>
            </h2>
          </div>
        </li>
      </ol>
    </section>

        <section class="border-green">
      <h2>Top 5 Artists</h2>
        <ol 
          style="
            display: flex; 
            justify-content: center; 
            gap: 2rem; 
            list-style-type: decimal;
            flex-wrap: wrap; /* if you want to wrap on smaller screens */
            padding-left: 0px;
          "
        >
        <li v-for="(artist, index) in topArtists" :key="artist.id" style="margin-bottom: 1rem;">
          <div class="card" style="width: 18rem; background-color: #212121;">
            <img :src="artist.images[0]?.url" class="card-img-top" alt="album cover">
            <h2>
              <div style="color: #1DB954; padding-bottom: 15px;">#{{ index + 1 }}</div>
              <span style="padding: 10px 14px;">{{ artist.name.length > 20 ? artist.name.slice(0, 20) + '...' : artist.name }}</span>
              <p class="card-text">popularity {{ artist.popularity }}</p>
            </h2>
          </div>
        </li>
      </ol>
    </section>
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
    const topArtists = ref([]);

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

      // Fetch top artists
      const topArtistsResponse = await fetch('https://api.spotify.com/v1/me/top/artists?limit=5', {
        headers: { Authorization: `Bearer ${accessToken}` }
      });
      if (topArtistsResponse.ok) {
        const data = await topArtistsResponse.json();
        topArtists.value = data.items;
      }
    });

    return { profile, topTracks, topArtists };
  }
});
</script>
