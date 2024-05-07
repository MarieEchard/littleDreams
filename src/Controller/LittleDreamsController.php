<?php

namespace App\Controller;


use App\Entity\ItemPortfolio;
use App\Form\ItemPortfolioType;
use App\Repository\CategorieRepository;
use App\Repository\ItemPortfolioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class LittleDreamsController extends AbstractController
{
    #[Route('/', name: 'app_littledreams')]
    public function index(ItemPortfolioRepository $itemPortfolioRepository, CategorieRepository $categoryRepository): Response
    {
        // Récupérer tous les ItemPortfolio
        $portfolioItems = $itemPortfolioRepository->findAll();
        $categories = $categoryRepository->findAll();

        return $this->render('littleDreams/littleDreamsAccueil.html.twig', [
            'portfolioItems' => $portfolioItems,
            'categories' => $categories,
        ]);
    }

    #[Route('/portfolio/creer', name: 'app_portfolio_creer_item')]
    public function creerItem(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {

        $item = new ItemPortfolio();
        $form = $this->createForm(ItemPortfolioType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('photo')->getData() instanceof UploadedFile) {
                $dir = $this->getParameter('photo_dir');
                $photoFile = $form->get('photo')->getData();
                $fileName = $slugger->slug($item->getNom()) . '-' . uniqid() . '.' . $photoFile->guessExtension();
                $photoFile->move($dir, $fileName);

                // Mettre à jour le champ 'photo' de l'item avec le nouveau nom de fichier
                $item->setPhoto($fileName);
            }

            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'Élément du portfolio créé avec succès.');
            return $this->redirectToRoute('app_littledreams');
        }


        // Afficher le formulaire de création d'un élément du portfolio
        return $this->render('littleDreams/creationItem.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/item/detail/{id}', name: 'app_itemPortfolio_detail')]
    public function detail(ItemPortfolio $item): Response
    {
        return $this->render('littleDreams/itemDetail.html.twig', [
            'item' => $item,
        ]);
    }
    #[Route('/portfolio/supprimer/{id}', name: 'app_portfolio_supprimer_item')]
    public function supprimerItem(ItemPortfolio $item, EntityManagerInterface $em): Response
    {

        // Supprimer l'élément du portfolio
        $em->remove($item);
        $em->flush();

        $this->addFlash('success', 'Élément du portfolio supprimé avec succès.');

        return $this->redirectToRoute('app_littledreams');
    }

}
