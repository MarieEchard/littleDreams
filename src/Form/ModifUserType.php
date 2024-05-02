<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ModifUserType extends AbstractType
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


        // L'utilisateur connecté modifie son propre profil et est Admin
        if ($options['estPropreProfil']) {
            if ($options['estAdmin']) {
                $builder
                    ->add('telephone', TextType::class, [
                        'label' => 'Numéro de téléphone :',
                        'required' => true,
                        'constraints' => [
                            new NotBlank(['message' => 'Veuillez saisir votre numéro de téléphone']),
                        ],
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
                    ->remove('nomSociete')
                    ->remove('noSiret')
                    ->remove('noRue')
                    ->remove('rue')
                    ->remove('codePostal')
                    ->remove('ville')
                    ->remove('estAdmin');

            // L'utilisateur connecté modifie son propre profil mais n'est pas Admin
            } else {
                $builder
                    ->add('telephone', TextType::class, [
                        'label' => 'Numéro de téléphone :',
                        'required' => true,
                        'constraints' => [
                            new NotBlank(['message' => 'Veuillez saisir votre numéro de téléphone']),
                        ],
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
                    ->remove('nomSociete')
                    ->remove('noSiret');

            }
        // L'utilisateur connecté est Admin et modifie un autre administrateur
        } else {
            if ($options['estAdmin']) {
                if ($options['userRoles'] == ['ROLE_ADMIN']) {
                    $builder
                        ->remove('telephone')
                        ->remove('plainPassword')
                        ->remove('photo')
                        ->remove('nomSociete')
                        ->remove('noSiret')
                        ->remove('noRue')
                        ->remove('rue')
                        ->remove('codePostal')
                        ->remove('ville');

                // L'utilisateur connecté est Admin et modifie un autre utilisateur
                } elseif ($options['userRoles'] == ['ROLE_USER']) {
                    $builder
                        ->remove('telephone')
                        ->remove('plainPassword')
                        ->remove('photo')
                        ->remove('noRue')
                        ->remove('rue')
                        ->remove('codePostal')
                        ->remove('ville')
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
                        ]);
                }

            }


        }

    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'estAdmin' => false,
            'estPropreProfil' => false,
            'estConnecte' => null,
            'user' => false,
            'userRoles' => [],
        ]);
    }
}




//            ->add('nom', TextType::class, [
//                'label' => 'Nom :',
//                'required' => false
//            ])
//            ->add('prenom', TextType::class, [
//                'label' => 'Prénom :',
//                'required' => false
//            ])
//            ->add('email', EmailType::class, [
//                'required' => false,
//                'label' => 'E-mail :',
//                'attr' => ['autocomplete' => 'email']
//            ])
//            ->add('telephone', TextType::class, [
//                'label' => 'Numéro de téléphone :',
//                'required' => !$options['estAdmin'],
//                'constraints' => [
//                    new NotBlank(['message' => 'Veuillez saisir votre numéro de téléphone']),
//                ],
//            ])
//            ->add('plainPassword', RepeatedType::class, [
//                'type' => PasswordType::class,
//                'required' => false,
//                'options' => [
//                    'attr' => [
//                        'autocomplete' => 'new-password',
//                    ],
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
//            ->add('nomSociete', TextType::class, [
//                'label' => 'Nom de société :',
//                'required' => false,
//                'constraints' => [
//                    new NotBlank(['message' => 'Veuillez saisir le nom de votre société']),
//                ],
//            ])
//            ->add('noSiret', TextType::class, [
//                'label' => 'N° de siret :',
//                'required' => false,
//                'constraints' => [
//                    new NotBlank(['message' => 'Veuillez saisir votre numéro de Siret']),
//                ],
//            ])
//            ->add('noRue', TextType::class, [
//                'label' => 'N° Rue :',
//                'required' => false,
//                'constraints' => [
//                    new NotBlank(['message' => 'Veuillez saisir le numéro de rue de votre adresse de facturation']),
//                ],
//            ])
//            ->add('rue', TextType::class, [
//                'label' => 'Rue :',
//                'required' => false,
//                'constraints' => [
//                    new NotBlank(['message' => 'Veuillez saisir la rue de votre adresse de facturation']),
//                ],
//            ])
//            ->add('codePostal', TextType::class, [
//                'label' => 'Code Postal :',
//                'required' => false,
//                'constraints' => [
//                    new NotBlank(['message' => 'Veuillez saisir le code postal de votre adresse de facturation']),
//                ],
//            ])
//            ->add('ville', TextType::class, [
//                'label' => 'Ville :',
//                'required' => false,
//                'constraints' => [
//                    new NotBlank(['message' => 'Veuillez saisir le nom de ville de votre adresse de facturation']),
//                ],
//            ])
//            ->add('estAdmin', CheckboxType::class, [
//                'label' => 'Est Administrateur',
//                'required' => false,
//                'mapped' => false,
//                'data' => $options['estAdmin'], // Préremplir avec la valeur passée depuis le contrôleur
//                'attr' => ['disabled' => !$options['estAdmin']], // Désactiver le champ si l'utilisateur n'est pas admin
//            ])
//            ->add('submit', SubmitType::class, [
//                'label' => 'Envoyer',
//                'attr' => [
//                ]
//            ])
//            ->add('return', ButtonType::class, [
//                'label' => 'Retour',
//                'attr' => [
//                    'onclick' => 'history.back()'
//                ]
//            ]);
//
//        $builder
//            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
//                $form = $event->getForm();
//                $form->getConfig()->getOptions();
//                $utilisateurModifie = $event->getData();
//                $utilisateurConnecte = $options['estConnecte'];
//
//                // L'utilisateur connecté modifie son propre profil
//                if ($options['estPropreProfil']) {
//                    if ($options['estAdmin']) {
//                        // L'utilisateur connecté modifie son propre profil et est Admin
//                        $form
//                            ->remove('email')
//                            ->remove('nomSociété')
//                            ->remove('noSiret')
//                            ->remove('noRue')
//                            ->remove('rue')
//                            ->remove('codePostal')
//                            ->remove('ville')
//                            ->remove('estAdmin');
//                    } else {
//                        // L'utilisateur connecté modifie son propre profil mais n'est pas Admin
//                        $form
//                            ->remove('email')
//                            ->remove('nomSociété')
//                            ->remove('noSiret')
//                            ->remove('estAdmin');
//                    }
//                } else {
//                    // Comparer les rôles
//                    $rolesUtilisateurConnecte = $utilisateurConnecte->getRoles();
//                    $rolesUtilisateurModifie = $utilisateurModifie->getRoles();
//
//                    // Vérifier si l'utilisateur connecté a le rôle approprié pour modifier l'utilisateur en cours
//                    if (in_array('ROLE_ADMIN', $rolesUtilisateurConnecte) && in_array('ROLE_ADMIN', $rolesUtilisateurModifie)) {
//                        // L'administrateur connecter modifie un Administrateur
//                        $form
//                            ->remove('telephone')
//                            ->remove('plainPassword')
//                            ->remove('photo')
//                            ->remove('nomSociété')
//                            ->remove('noSiret')
//                            ->remove('noRue')
//                            ->remove('rue')
//                            ->remove('codePostal')
//                            ->remove('ville');
//
//                    } elseif (in_array('ROLE_ADMIN', $rolesUtilisateurConnecte) && in_array('ROLE_USER', $rolesUtilisateurModifie)) {
//                        //l'administrateur connecté modifie un utilisateur non admin
//                        $form
//                            ->remove('nom')
//                            ->remove('prenom')
//                            ->remove('telephone')
//                            ->remove('plainPassword')
//                            ->remove('photo')
//                            ->remove('noRue')
//                            ->remove('rue')
//                            ->remove('codePostal')
//                            ->remove('ville')
//                            ->remove('estAdmin');
//
//                    }
//                }
//
//            });
//
//
//
//    public function configureOptions(OptionsResolver $resolver): void
//    {
//        $resolver->setDefaults([
//            'data_class' => User::class,
//            'estAdmin' => false,
//            'estPropreProfil' => false,
//            'estConnecte' => null,
//        ]);
//    }
//}