<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/devis', name: 'app_devis')]
class DevisController extends AbstractController
{
    #[Route('/demande', name: '_demande')]
    public function index(): Response
    {
        return $this->render('projet/budgetProjet.html.twig');
    }
}
