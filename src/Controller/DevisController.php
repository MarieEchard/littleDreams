<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\BudgetType;
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


        $form = $this->createForm(BudgetType::class, $projet);
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

    #[Route('/validation_liste', name: '_validation_liste')]
    public function listeDevisEnAttente(EntityManagerInterface $em): Response
    {
        // Récupérer toutes les demandes de devis en attente depuis la base de données
        $repoProjet = $em->getRepository(Projet::class);
        $projetEnAttente = $repoProjet->findBy(['statut' => 'en attente']);

        // Passer les rendez-vous en attente au template Twig pour les afficher
        return $this->render('projet/validationBudgetProjet.html.twig', [
            'projetEnAttente' => $projetEnAttente,
        ]);
    }

    #[Route('/validation/{id}', name: '_valider')]
    public function validerDevis(Projet $projet, EntityManagerInterface $em): Response
    {
        $projet->setStatut('valide');
        $em->flush();

        $this->addFlash('success', 'Le projet a été validé avec succès !');
        return $this->redirectToRoute('app_devis_validation_liste');
    }

// Méthode pour refuser/supprimer un rendez-vous
    #[Route('/refus/{id}', name: '_refus')]
    public function refuserDevis(Projet $projet, EntityManagerInterface $em): Response
    {
        $em->remove($projet);
        $em->flush();

        $this->addFlash('success', 'Le rendez-vous a été refusé avec succès !');
        return $this->redirectToRoute('app_devis_validation_liste');
    }

    #[Route('/mesprojets/{id}', name: '_mesprojets')]
    public function mesProjets(int $id, EntityManagerInterface $em): Response
    {

        // Récupérer le repository de l'entité Question
        $projetUtilisateur = $em->getRepository(Projet::class)->findBy(['user' => $id, 'statut' => 'valide']);
        // Rendre la vue Twig en transmettant les projet à afficher
        return $this->render('projet/mesProjets.html.twig', [
            'projetUtilisateur' => $projetUtilisateur,
        ]);
    }


}
