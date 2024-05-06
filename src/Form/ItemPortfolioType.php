<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\ItemPortfolio;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ItemPortfolioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('objectifClient', TextareaType::class, [
                'label' => 'Objectif du client'
            ])
            ->add('photo', FileType::class, [
                'required' => false,
                'label' => 'Photo de démo :',
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => "Ce format n'est pas bon",
                        'maxSizeMessage' => "Ce fichier est trop lourd"
                    ])
                ]
            ])
            ->add('categories', EntityType::class, [
                'class' =>  Categorie::class,
                'choice_label' => 'nomCategorie',
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'créer',
            ])
            ->add('return', ButtonType::class, [
                'label' => 'Retour',
                'attr' => [
                    'onclick' => 'history.back()'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ItemPortfolio::class,
        ]);
    }
}