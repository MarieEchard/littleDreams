<?php

namespace App\Form;

use App\Entity\Projet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class BudgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('budget', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le champ budget ne peut pas être vide.']),
                    new Assert\Type(['type' => 'numeric', 'message' => 'Le budget doit être un nombre.']),
                ],
            ])

            ->add('categorie', EntityType::class, [
                'class' => 'App\Entity\Categorie',
                'choice_label' => 'nomCategorie', // Remplacez 'nom' par le nom de la propriété à afficher dans la liste des choix
            ])
            ->add('details', TextareaType::class, [
                'attr' => ['rows' => 5],
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-primary submit-button'
                ]
            ])
            ->add('return', ButtonType::class, [
                'label' => 'Retour',
                'attr' => [
                    'class' => 'btn btn-secondary',
                    'onclick' => 'history.back()'
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}