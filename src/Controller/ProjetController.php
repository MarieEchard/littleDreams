<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\RendezVous;
use App\Form\BudgetType;
use App\Form\ProjetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/projet', name: 'app_projet')]
class ProjetController extends AbstractController
{

    #[Route('/valides', name: '_valides')]
    public function projetsValides(EntityManagerInterface $em): Response
    {
        // Récupérer le repository de l'entité Projet
        $projetsValides = $em->getRepository(Projet::class)->findBy(['statut' => 'valide']);

        // Rendre la vue Twig en transmettant les projets validés à afficher
        return $this->render('projet/projetsValides.html.twig', [
            'projetsValides' => $projetsValides,
        ]);
    }

    #[Route('/modifier/{id}', name: '_modifier', requirements: ['id' => '\d+'])]
    public function update(Request $request, EntityManagerInterface $em, Projet $projet): Response
    {
        $rendezVous = $em->getRepository(RendezVous::class)->findAll();

        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les modifications en base de données
            $em->flush();

            // Rediriger vers une autre page après la modification
            return $this->redirectToRoute('app_projet_valides');
        }

        // Afficher le formulaire de modification
        return $this->render('projet/modifierProjet.html.twig', [
            'form' => $form->createView(),
            'rendezVous' => $rendezVous,
        ]);
    }
}
