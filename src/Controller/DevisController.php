<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/devis', name: 'app_devis')]
class DevisController extends AbstractController
{
    #[Route('/demande', name: '_demande')]
    public function nouvelleDemandeBudget(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $projet = new Projet();
        $projet -> setUser($user);


        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projet->setStatut('en attente');


            $entityManager->persist($projet);
            $entityManager->flush();

            $this->addFlash('success', 'Votre demande de budget a été envoyée avec succès !');
            return $this->redirectToRoute('app_littledreams');
        }

        // Affichage du formulaire dans le template Twig
        return $this->render('projet/budgetProjet.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
