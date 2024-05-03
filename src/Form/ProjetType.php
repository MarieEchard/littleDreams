<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\RendezVous;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints as Assert;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut', DateType::class, [
                'label' => 'Date de debut:',
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Date de fin:',
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('resteAPayer', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le champ reste à payer ne peut pas être vide.']),
                    new Assert\Type(['type' => 'numeric', 'message' => 'Le reste à payer doit être un nombre.']),
                ],
            ])
//            ->add('rendezVous', EntityType::class, [
//                'class' => RendezVous::class,
//                'choice_label' => 'nom',
//                'choices' => $options['rendezVous'],
//            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-primary'
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
//            'rendezVous' => [],
        ]);
    }
}