<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Form\RendezVousType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/rendezvous', name: 'app_rendezvous')]
class RendezVousController extends AbstractController
{
    #[Route('/demande', name: '_demande')]
    public function demandeRendezVous(Request $request, EntityManagerInterface $em): Response
    {
        $rendezVous = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rendezVous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateHeureRdv = $rendezVous->getDateHeure();

            // Vérifier si la demande est effectuée en dehors de la plage horaire autorisée (18h - 8h)
            $heureDemande = (int)$dateHeureRdv->format('H');
            if ($heureDemande < 9 || $heureDemande >= 18) {
                $this->addFlash('error', 'Vous ne pouvez pas prendre de rendez-vous en dehors de la plage horaire autorisée (de 9h à 18h).');
                return $this->redirectToRoute('app_rendezvous_demande');
            }

            // Vérifier si la demande est effectuée un samedi ou dimanche
            $jourDemande = $dateHeureRdv->format('N');
            if ($jourDemande == 6 || $jourDemande == 7) {
                $this->addFlash('error', 'Vous ne pouvez pas prendre de rendez-vous les samedis et dimanches.');
                return $this->redirectToRoute('app_rendezvous_demande');
            }

            $rendezVous->setStatut('en attente');
            $rendezVous->setUser($this->getUser());

            $em->persist($rendezVous);
            $em->flush();

            $this->addFlash('success', 'Votre demande de rendez-vous a été envoyée avec succès ! Nous y répondrons dans les plus brefs délais !');
            return $this->redirectToRoute('app_littledreams');
        }

        return $this->render('rendez_vous/rendezVous.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/validation_liste', name: '_validation_liste')]
    public function listeRendezVousEnAttente(EntityManagerInterface $em): Response
    {
        // Récupérer tous les rendez-vous en attente depuis la base de données
        $repoRendezVous = $em->getRepository(RendezVous::class);
        $rendezVousEnAttente = $repoRendezVous->findBy(['statut' => 'en attente']);

        // Passer les rendez-vous en attente au template Twig pour les afficher
        return $this->render('rendez_vous/validationRendezVous.html.twig', [
            'rendezVousEnAttente' => $rendezVousEnAttente,
        ]);
    }

    // Méthode pour valider un rendez-vous
    #[Route('/validation/{id}', name: '_valider')]
    public function validerRendezVous(RendezVous $rendezVous, EntityManagerInterface $em): Response
    {
        $rendezVous->setStatut('valide');
        $em->flush();

        $this->addFlash('success', 'Le rendez-vous a été validé avec succès !');
        return $this->redirectToRoute('app_rendezvous_validation_liste');
    }

// Méthode pour refuser/supprimer un rendez-vous
    #[Route('/refus/{id}', name: '_refus')]
    public function refuserRendezVous(RendezVous $rendezVous, EntityManagerInterface $em): Response
    {
        $em->remove($rendezVous);
        $em->flush();

        $this->addFlash('success', 'Le rendez-vous a été refusé avec succès !');
        return $this->redirectToRoute('app_rendezvous_validation_liste');
    }

    #[Route('/personnels//{id}', name: '_personnels')]
    public function mesRendezvous(int $id, EntityManagerInterface $em): Response
    {

        // Récupérer le repository de l'entité Question
        $rdvUtilisateur = $em->getRepository(RendezVous::class)->findBy(['user' => $id, 'statut' => 'valide']);
        // Rendre la vue Twig en transmettant les questions à afficher
        return $this->render('rendez_vous/mesRendezVous.html.twig', [
            'rdvUtilisateur' => $rdvUtilisateur,
        ]);
    }
}
