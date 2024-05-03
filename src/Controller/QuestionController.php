<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Form\ResponseType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class QuestionController extends AbstractController
{
    #[Route('/question', name: 'app_question')]
    public function question(Request $request, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator): Response
    {

        // Créez un formulaire en utilisant le type de formulaire QuestionType
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        // Si le formulaire est soumis, enregistrer la question
        if ($form->isSubmitted() && $form->isValid()) {
            // Obtenez les données du formulaire
            $question = $form->getData();
            // Définir la date actuelle
            $question->setDate(new DateTime());

            $question->setStatut('en attente');
            // Enregistrer la question dans la base de données
            $em->persist($question);
            $em->flush();

            // Rediriger l'utilisateur vers une page de confirmation ou toute autre page appropriée
            $this->addFlash('success', 'Votre question a été envoyée avec succès ! Nous y répondrons dans les plus brefs délais !');
            return $this->redirectToRoute('app_littledreams');
        }

        // Rendre le formulaire Twig
        return $this->render('question/question.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/mes-questions', name: 'app_mes-questions')]
    public function mesQuestions(EntityManagerInterface $em): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Récupérer le repository de l'entité Question
        $questions = $em->getRepository(Question::class)->findBy(['user' => $user]);
        // Rendre la vue Twig en transmettant les questions à afficher
        return $this->render('question/mesQuestions.html.twig', [
            'questions' => $questions,
        ]);
    }

    #[Route('/question/reponse', name: 'app_question_reponse')]
    public function repondreQuestions(EntityManagerInterface $em, Request $request): Response
    {
        // Obtenez l'utilisateur actuel
        $user = $this->getUser();

        // Obtenez les rôles de l'utilisateur
        $userRoles = $user ? $user->getRoles() : [];
        $questions = $em->getRepository(Question::class)->findBy(['reponse' => null]);

        $questionForms = [];
        foreach ($questions as $question) {
            $form = $this->createForm(QuestionType::class, $question, ['user_roles' => $userRoles]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $em->flush();

                $this->addFlash('success', 'La réponse à été envoyée !');
                return $this->redirectToRoute('app_question_reponse');
            }

            $questionForms[] = $form->createView();
        }

        return $this->render('question/reponseQuestion.html.twig', [
            'questionForms' => $questionForms,
        ]);
    }

}
