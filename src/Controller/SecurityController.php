<?php

namespace App\Controller;

use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, EntityManagerInterface $em): Response
    {

        // Récupérer les erreurs d'authentification de AuthenticationUtils
        $error = $authenticationUtils->getLastAuthenticationError();

        // Récupérer le dernier nom d'utilisateur saisi
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($error instanceof AuthenticationException) {
            $this->addFlash('danger', 'L\'email ou le mot de passe est incorrect.');
        }

        // Si l'utilisateur est connecté, exécutez le code pour associer les questions en attente à son compte
        if ($this->getUser() !== null) {
            // Récupérer l'utilisateur connecté
            $user = $this->getUser();

            // Récupérer le repository de l'entité Question
            $questionRepository = $em->getRepository(Question::class);

            // Récupérer les questions en attente associées à l'email de l'utilisateur connecté
            $questionsEnAttentes = $questionRepository->trouverQuestionsEnAttenteParEmail($user->getEmail());

            // Mettre à jour le statut des questions en attente et associez-les à l'utilisateur
            foreach ($questionsEnAttentes as $questionEnAttente) {
                $questionEnAttente->setStatus([Question::STATUS_ASSOCIEE]);
                $questionEnAttente->setUser($user);
                $em->persist($questionEnAttente);
            }

            // Enregistrer les modifications dans la base de données
            $em->flush();
        }

        // Rediriger l'utilisateur vers une page appropriée
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('Cette méthode peut être vide - elle sera interceptée par la clé de déconnexion sur votre pare-feu.');
    }
}
