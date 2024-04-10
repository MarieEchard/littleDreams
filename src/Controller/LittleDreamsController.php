<?php

namespace App\Controller;

use App\Entity\ItemPortfolio;
use App\Form\ItemPortfolioType;
use App\Repository\ItemPortfolioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LittleDreamsController extends AbstractController
{
    #[Route('/', name: 'app_littledreams')]
    public function index(ItemPortfolioRepository $itemPortfolioRepository): Response
    {
        // Récupérer tous les ItemPortfolio
        $itemPortfolios = $itemPortfolioRepository->findAll();

        return $this->render('littleDreams/littleDreamsAccueil.html.twig', [
            'itemPortfolios' => $itemPortfolios,
        ]);
    }
}
