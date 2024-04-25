<?php
//
//namespace App\Form;
//
//use App\Entity\User;
//use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\Extension\Core\Type\ButtonType;
//use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
//use Symfony\Component\Form\Extension\Core\Type\EmailType;
//use Symfony\Component\Form\Extension\Core\Type\FileType;
//use Symfony\Component\Form\Extension\Core\Type\PasswordType;
//use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\Form\FormEvent;
//use Symfony\Component\Form\FormEvents;
//use Symfony\Component\OptionsResolver\OptionsResolver;
//use Symfony\Component\Validator\Constraints\File;
//use Symfony\Component\Validator\Constraints\NotBlank;
//use Symfony\Component\Validator\Constraints\Regex;
//
//class UserType extends AbstractType
//{
//    public function buildForm(FormBuilderInterface $builder, array $options): void
//    {
//        $builder
//            ->add('email', EmailType::class, [
//                'required' => false,
//                'label' => 'E-mail :',
//                'attr' => ['autocomplete' => 'email']
//            ])
//            ->add('plainPassword', RepeatedType::class, [
//                'type' => PasswordType::class,
//                'required' => false,
//                'options' => [
//                    'attr' => [
//                        'autocomplete' => 'new-password',
//                        ],
//                ],
//                'first_options' => [
//                    'constraints' => [
//                        new Regex('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{14,}$/',
//                            "Il faut un mot de passe de 14 caractères minimum avec au moins une majuscule, une minuscule, un chiffre et un caractère spécial")
//                    ],
//                    'label' => 'Mot de passe:',
//                ],
//                'second_options' => [
//                    'label' => 'Confirmation du mot de passe:',
//                ],
//                'invalid_message' => 'Les mots de passes ne correspondent pas',
//                'mapped' => false,
//            ])
//
//
//            ->add('nom', TextType::class, [
//                'label' => 'Nom :',
//                'required' => false
//            ])
//            ->add('prenom', TextType::class, [
//                'label' => 'Prénom :',
//                'required' => false
//            ])
//
//            ->add('telephone', TextType::class, [
//                'label' => 'Numéro de téléphone :',
//                'required' => !$options['estAdmin'],
//                'constraints' => [
//                    new NotBlank(['message' => 'Veuillez saisir votre numéro de téléphone']),
//                ],
//            ])
//
//            ->add('photo', FileType::class, [
//                'required' => false,
//                'label' => 'Photo de profil :',
//                'mapped' => false,
//                'constraints' => [
//                    new File([
//                        'maxSize' => '1024k',
//                        'mimeTypes' => [
//                            'image/jpeg',
//                            'image/jpg',
//                            'image/png',
//                        ],
//                        'mimeTypesMessage' => "Ce format n'est pas bon",
//                        'maxSizeMessage' => "Ce fichier est trop lourd"
//                    ])
//                ]
//            ])
//
//            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
//                $user = $event->getData();
//                $form = $event->getForm();
//
//                // Si l'utilisateur est un administrateur
//                if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
//                    $form->remove('nomSociete');
//                    $form->remove('noSiret');
//                    $form->remove('noRue');
//                    $form->remove('rue');
//                    $form->remove('codePostal');
//                    $form->remove('ville');
//                    // Si l'utilisateur est administrateur, retirer le champ "estAdmin"
//                    $form->remove('estAdmin');
//                } else {
//                    // Si l'utilisateur n'est pas un administrateur, retirer les champs spécifiques
//                    $form->remove('nom');
//                    $form->remove('prenom');
//                    $form->remove('telephone');
//                    $form->remove('email');
//                    $form->remove('nomSociete');
//                    $form->remove('noSiret');
//                    $form->remove('noRue');
//                    $form->remove('rue');
//                    $form->remove('codePostal');
//                    $form->remove('ville');
//                    // Retirer le champ "estAdmin" pour les utilisateurs normaux
//                    $form->remove('estAdmin');
//                }
//            })
//
//
//            ->add('nomSociete', TextType::class, [
//                'label' => 'Nom de votre société :',
//                'required' => !$options['estAdmin'],
//                'constraints' => [
//                    new NotBlank(['message' => 'Veuillez saisir le nom de votre société']),
//                ],
//            ])
//
//            ->add('noSiret', TextType::class, [
//                'label' => 'N° de siret :',
//                'required' => !$options['estAdmin'],
//                'constraints' => [
//                    new NotBlank(['message' => 'Veuillez saisir votre numéro de Siret']),
//                ],
//            ])
//
//            ->add('noRue', TextType::class, [
//                'label' => 'N° Rue :',
//                'required' => !$options['estAdmin'],
//                'constraints' => [
//                    new NotBlank(['message' => 'Veuillez saisir le numéro de rue de votre adresse de facturation']),
//                ],
//            ])
//            ->add('rue', TextType::class, [
//                'label' => 'Rue :',
//                'required' => !$options['estAdmin'],
//                'constraints' => [
//                    new NotBlank(['message' => 'Veuillez saisir la rue de votre adresse de facturation']),
//                ],
//            ])
//            ->add('codePostal', TextType::class, [
//                'label' => 'Code Postal :',
//                'required' => !$options['estAdmin'],
//                'constraints' => [
//                    new NotBlank(['message' => 'Veuillez saisir le code postal de votre adresse de facturation']),
//                ],
//            ])
//            ->add('ville', TextType::class, [
//                'label' => 'Ville :',
//                'required' => !$options['estAdmin'],
//                'constraints' => [
//                    new NotBlank(['message' => 'Veuillez saisir le nom de ville de votre adresse de facturation']),
//                ],
//            ])


//    public function configureOptions(OptionsResolver $resolver): void
//    {
//        $resolver->setDefaults([
//            'data_class' => User::class,
//            'estAdmin' => false,
//        ]);
//    }
//}

// src/Form/UserType.php


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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom :',
                'required' => false
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom :',
                'required' => false
            ])
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

            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                ]
            ])
            ->add('return', ButtonType::class, [
                'label' => 'Retour',
                'attr' => [
                    'onclick' => 'history.back()'
                ]
            ]);
        if ($options['estPropreProfil']) {
            // Seul l'utilisateur lui-même peut modifier son mot de passe et sa photo de profil
            $builder
                ->add('telephone', TextType::class, [
                    'label' => 'Numéro de téléphone :',
                    'required' => !$options['estAdmin'],
                    'constraints' => [
                        new NotBlank(['message' => 'Veuillez saisir votre numéro de téléphone']),
                    ],
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
                ]);
        }
        if (!$options['estPropreProfil'] && $options['estAdmin']) {
// Si un administrateur est en train de modifier le profil d'un autre utilisateur
            $builder
                ->add('nomSociete', TextType::class, [
                    'label' => 'Nom de société :',
                    'required' => false,
                    'constraints' => [
                        new NotBlank(['message' => 'Veuillez saisir le nom de votre société']),
                    ],
                ])
                ->add('noSiret', TextType::class, [
                    'label' => 'N° de siret :',
                    'required' => false,
                    'constraints' => [
                        new NotBlank(['message' => 'Veuillez saisir votre numéro de Siret']),
                    ],
                ])
                ->add('noRue', TextType::class, [
                    'label' => 'N° Rue :',
                    'required' => false,
                    'constraints' => [
                        new NotBlank(['message' => 'Veuillez saisir le numéro de rue de votre adresse de facturation']),
                    ],
                ])
                ->add('rue', TextType::class, [
                    'label' => 'Rue :',
                    'required' => false,
                    'constraints' => [
                        new NotBlank(['message' => 'Veuillez saisir la rue de votre adresse de facturation']),
                    ],
                ])
                ->add('codePostal', TextType::class, [
                    'label' => 'Code Postal :',
                    'required' => false,
                    'constraints' => [
                        new NotBlank(['message' => 'Veuillez saisir le code postal de votre adresse de facturation']),
                    ],
                ])
                ->add('ville', TextType::class, [
                    'label' => 'Ville :',
                    'required' => false,
                    'constraints' => [
                        new NotBlank(['message' => 'Veuillez saisir le nom de ville de votre adresse de facturation']),
                    ],
                ])
                ->add('estAdmin', CheckboxType::class, [
                    'label' => 'Est Administrateur',
                    'required' => false,
                    'mapped' => false, // Ne pas mapper cette propriété à l'entité User
                    'data' => $options['estAdmin'], // Préremplir avec la valeur passée depuis le contrôleur
                    'attr' => ['disabled' => !$options['estAdmin']], // Désactiver le champ si l'utilisateur n'est pas admin
                ]);

        }
        if ($options['isNewUser'] && $options['estAdmin']) {
            $builder
                ->remove('telephone')
                ->remove('nomSociete')
                ->remove('noSiret')
                ->remove('noRue')
                ->remove('rue')
                ->remove('codePostal')
                ->remove('ville');
        }

        if ($options['isNewUser'] && !$options['estAdmin']) {
            $builder
                ->add('telephone', TextType::class, [
                    'label' => 'Numéro de téléphone :',
                    'required' => true,
                    'constraints' => [
                        new NotBlank(['message' => 'Veuillez saisir votre numéro de téléphone']),
                    ],
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
                ->add('nomSociete', TextType::class, [
                    'label' => 'Nom de société :',
                    'required' => false,
                    'constraints' => [
                        new NotBlank(['message' => 'Veuillez saisir le nom de votre société']),
                    ],
                ])
                ->add('noSiret', TextType::class, [
                    'label' => 'N° de siret :',
                    'required' => false,
                    'constraints' => [
                        new NotBlank(['message' => 'Veuillez saisir votre numéro de Siret']),
                    ],
                ])
                ->add('noRue', TextType::class, [
                    'label' => 'N° Rue :',
                    'required' => false,
                    'constraints' => [
                        new NotBlank(['message' => 'Veuillez saisir le numéro de rue de votre adresse de facturation']),
                    ],
                ])
                ->add('rue', TextType::class, [
                    'label' => 'Rue :',
                    'required' => false,
                    'constraints' => [
                        new NotBlank(['message' => 'Veuillez saisir la rue de votre adresse de facturation']),
                    ],
                ])
                ->add('codePostal', TextType::class, [
                    'label' => 'Code Postal :',
                    'required' => false,
                    'constraints' => [
                        new NotBlank(['message' => 'Veuillez saisir le code postal de votre adresse de facturation']),
                    ],
                ])
                ->add('ville', TextType::class, [
                    'label' => 'Ville :',
                    'required' => false,
                    'constraints' => [
                        new NotBlank(['message' => 'Veuillez saisir le nom de ville de votre adresse de facturation']),
                    ],
                ]);
        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'estAdmin' => false,
            'estPropreProfil' => false,
            'can_modify' => false,
            'isNewUser' => false,
        ]);
    }
}


