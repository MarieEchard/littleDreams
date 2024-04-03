<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/profil', name: 'app_profil')]
class UserController extends AbstractController
{
    #[Route('/{id}', name: '', requirements: ['id' => '\d+'])]
    public function profil(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException("L'utilisateur n'existe pas!");
        }

        return $this->render('user/profil.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/creer', name: '_creer')]
    public function creer(Request $request, EntityManagerInterface $em, SluggerInterface $slugger, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('photo')->getData() instanceof UploadedFile) {
                $photoFile = $form->get('photo')->getData();
                $fileName = $slugger->slug($user->getNom()) . '-' . uniqid() . '.' . $photoFile->guessExtension();
                $photoFile->move($this->getParameter('photo_dir'), $fileName);
                $user->setPhoto($fileName);
            }

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            // Attribution du rôle ROLE_ADMIN si le champ estAdministrateur est coché
            if ($form->get('estAdministrateur')->getData()) {
                $user->setRoles(['ROLE_ADMIN']);
            }

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'L\'utilisateur a été enregistrée');
            return $this->redirectToRoute('app_profil', ['id' => $user->getId()]);
        }

        return $this->render('user/creationProfil.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/modifier/{id}', name: '_modifier', requirements: ['id' => '\d+'])]
    public function update(int $id, UserRepository $userRepository, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $user = $userRepository->find($id);

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('photo')->getData() instanceof UploadedFile) {
                $dir = $this->getParameter('photo_dir');
                $photoFile = $form->get('photo')->getData();
                $fileName = $slugger->slug($user->getNom()) . '-' . uniqid() . '.' . $photoFile->guessExtension();
                $photoFile->move($dir, $fileName);

                if ($user->getPhoto() && \file_exists($dir . '/' . $user->getPhoto())) {
                    unlink($dir . '/' . $user->getPhoto());
                }

                $user->setPhoto($fileName);

            }

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'L\'utilisateur a été modifié');
            return $this->redirectToRoute('app_profil', ['id' => $id]);
        }

        return $this->render('user/modifierProfil.html.twig', [
            'form' => $form,
            'user' => $user
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer', requirements: ['id' => '\d+'])]
    public function supprimer(int $id, UserRepository $userRepository, EntityManagerInterface $em): Response
    {
        $user = $userRepository->find($id);

        // Récupérer tous les projets de l'utilisateur
        $projets = $user->getProjets();

        // Parcourir les projets de l'utilisateur pour vérifier s'il y a des paiements associés
        foreach ($projets as $projet) {
            // Vérifier s'il y a des paiements associés à ce projet
            if ($projet->getPaiements() > 0) {
                // S'il y a des paiements associés à ce projet, on empêche la suppression de l'utilisateur
                $this->addFlash('danger', 'Impossible de supprimer votre compte, il a des paiements en cours ou en attente.');
                return $this->redirectToRoute('app_littledreams');
            }
        }

        // Si aucun paiement en cours associé aux projets de l'utilisateur, on peut supprimer l'utilisateur
        $em->remove($user);
        $em->flush();

        $this->addFlash('success', 'L\'utilisateur a été supprimé!');

        return $this->redirectToRoute('app_littledreams');
    }

}
