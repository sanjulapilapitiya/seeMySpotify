<?php

// src/Controller/SpotifyController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;

class spotifyController extends AbstractController
{
    #[Route('/spotify/login', name: 'spotify_login')]
    public function login()
    {
        $clientId = getenv('SPOTIFY_CLIENT_ID');
        $redirectUri = 'http://localhost:8000/spotify/callback'; // Change for prod
        $scopes = 'user-read-private user-read-email';

        $authorizeUrl = 'https://accounts.spotify.com/authorize?' . http_build_query([
            'client_id' => $clientId,
            'response_type' => 'code',
            'redirect_uri' => $redirectUri,
            'scope' => $scopes,
            'show_dialog' => 'true',
        ]);

        return new RedirectResponse($authorizeUrl);
    }

    #[Route('/spotify/callback', name: 'spotify_callback')]
    public function callback(Request $request): Response
    {
        $code = $request->query->get('code');
        $error = $request->query->get('error');

        if ($error) {
            return new Response('Spotify auth error: ' . htmlspecialchars($error));
        }

        if (!$code) {
            return new Response('Authorization code not found');
        }

        $clientId = getenv('SPOTIFY_CLIENT_ID');
        $clientSecret = getenv('SPOTIFY_CLIENT_SECRET');
        $redirectUri = 'http://localhost:8000/spotify/callback';

        $tokenUrl = 'https://accounts.spotify.com/api/token';

        $params = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUri,
        ];

        $basicAuth = base64_encode($clientId . ':' . $clientSecret);

        $client = HttpClient::create();

        $response = $client->request('POST', $tokenUrl, [
            'headers' => [
                'Authorization' => 'Basic ' . $basicAuth,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'body' => $params,
        ]);

        $data = $response->toArray();

        if (isset($data['access_token'])) {
            $accessToken = $data['access_token'];
            return new Response('Access Token: ' . htmlspecialchars($accessToken));
        }

        return new Response('Failed to get access token');
    }
}

