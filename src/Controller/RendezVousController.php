<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Form\RendezVousType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RendezVousController extends AbstractController
{
    #[Route('/rendezvous', name: 'app_rendezvous')]
    public function demandeRendezVous(Request $request, EntityManagerInterface $em): Response
    {
        $rendezVous = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rendezVous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Marquer le rendez-vous comme en attente
            $rendezVous->setStatut('en attente');

            // Assigner l'utilisateur connecté au rendez-vous
            $rendezVous->setUser($this->getUser());

            // Enregistrer le rendez-vous en base de données
            $em->persist($rendezVous);
            $em->flush();

            $this->addFlash('success', 'Votre demande de rendez-vous a été envoyée avec succès ! Nous y répondrons dans les plus brefs délais !');
            return $this->redirectToRoute('app_littledreams');
        }

        return $this->render('rendez_vous/rendezVous.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
