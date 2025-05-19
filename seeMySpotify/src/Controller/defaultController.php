<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class defaultController extends AbstractController
{
    #[Route('/', name: 'vue_home')]
    public function home(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/spotify-dashboard', name: 'vue_spotify_dashboard')]
    public function spotifyDashboard(): Response
    {
        return $this->render('base.html.twig');
    }
}

