<?php

namespace App\Controller;

use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class QuestionController extends AbstractController
{
    #[Route('/question', name: 'app_question')]
    public function question(Request $request, EntityManagerInterface $em): Response
    {

        // Si le formulaire est soumis, enregistrer la question
        if ($request->isMethod('POST')) {
            // Récupérer les données du formulaire de la requête
            $questionData = $request->request->get('question');

            // Créer une nouvelle instance de Question
            $question = new Question();
            $question->setQuestion($questionData['content']);
            $question->setEmail($questionData['email']);
            $question->setStatus(Question::STATUS_PENDING); // Indicateur que la question est en attente

            // Enregistrer la question dans la base de données
            $em->persist($question);
            $em->flush();

            // Rediriger l'utilisateur vers une page de confirmation ou toute autre page appropriée
            return $this->redirectToRoute('app_littledreams');
        }
        return $this->render('question/question.html.twig');
    }

}
