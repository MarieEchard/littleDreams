<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
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
        $questionRepository = $em->getRepository(Question::class);

        // Récupérer les questions de l'utilisateur connecté
        $questions = $questionRepository->findBy(['user' => $user]);

        // Rendre la vue Twig en transmettant les questions à afficher
        return $this->render('question/mesQuestions.html.twig', [
            'questions' => $questions,
        ]);
    }

}
