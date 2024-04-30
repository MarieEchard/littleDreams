<?php

namespace App\Controller;

use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategorieController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    #[Route('/services', name: 'app_services')]
    public function index(): Response
    {
        $categories = $this->entityManager->getRepository(Categorie::class)->findAll();

        return $this->render('littleDreams/services.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/categorie/ajouter', name: 'app_services_ajouter')]
    public function ajouterCategorie(Request $request): RedirectResponse
    {
        $nomCategorie = $request->request->get('nom_categorie');

        if (!empty($nomCategorie)) {
            $categorie = new Categorie();
            $categorie->setNomCategorie($nomCategorie);

            $this->entityManager->persist($categorie);
            $this->entityManager->flush();

            $this->addFlash('success', 'Le service a été ajoutée avec succès.');
        } else {
            $this->addFlash('error', 'Le nom du service ne peut pas être vide.');
        }

        return $this->redirectToRoute('app_services');
    }

    #[Route('/categorie/{id}/supprimer', name: 'app_services_supprimer')]
    public function supprimerCategorie(Categorie $categorie): RedirectResponse
    {
        $this->entityManager->remove($categorie);
        $this->entityManager->flush();

        $this->addFlash('success', 'Le service a été supprimé avec succès.');

        return $this->redirectToRoute('app_services');
    }
}
