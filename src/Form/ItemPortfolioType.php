<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;

class ItemPortfolioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => false,
                'label' => 'E-mail :',
                'attr' => ['autocomplete' => 'email']
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => false,
                'options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        ],
                ],
                'first_options' => [
                    'constraints' => [
                        new Regex('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{14,}$/',
                            "Il faut un mot de passe de 14 caractères minimum avec au moins une majuscule, une minuscule, un chiffre et un caractère spécial")
                    ],
                    'label' => 'Mot de passe:',
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe:',
                ],
                'invalid_message' => 'Les mots de passes ne correspondent pas',
                'mapped' => false,
            ])


            ->add('nom', TextType::class, [
                'label' => 'Votre nom :',
                'required' => false
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Votre prénom :',
                'required' => false
            ])

            ->add('telephone', TextType::class, [
                'label' => 'Numéro de téléphone :',
                'required' => false
            ])

            ->add('nomSociete', TextType::class, [
                'label' => 'Nom de votre société :',
                'required' => false
            ])

            ->add('photo', FileType::class, [
                'required' => false,
                'label' => 'Photo de profil :',
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

            ->add('noRue', TextType::class, [
                'label' => 'N° Rue :',
                'required' => false
            ])
            ->add('rue', TextType::class, [
                'label' => 'Rue :',
                'required' => false
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code Postal :',
                'required' => false
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville :',
                'required' => false
            ])

//            ->add('estAdministrateur', CheckboxType::class, [
//                'label' => 'Créer en tant qu\'administrateur',
//                'required' => false,
//                'mapped' => false,
//            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
//                    'class' => 'btn btn-primary mr-2'
                ]
            ])
            ->add('return', ButtonType::class, [
                'label' => 'Retour',
                'attr' => [
//                    'class' => 'btn btn-secondary',
                    'onclick' => 'history.back()'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}