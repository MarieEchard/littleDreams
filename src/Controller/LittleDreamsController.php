<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LittleDreamsController extends AbstractController
{
    #[Route('/', name: 'app_littledreams')]
    public function index(): Response
    {
        return $this->render('littleDreams/littleDreamsAccueil.html.twig');
    }
}