<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('email', EmailType::class, [
                'required' => false,
                'label' => 'E-mail :',
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'white-text']
            ])

            ->add('question', TextareaType::class, [
                'label' => 'Quelle est votre question ?',
                'required' => false,
                'attr' => ['class' => 'form-control',
                    'rows' =>8,],
                'label_attr' => ['class' => 'white-text']
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
        if (in_array('ROLE_ADMIN', $options['user_roles'])) {
            $builder
                ->remove('email')
                ->remove('question')
                ->add('reponse', TextareaType::class, [
                'label' => 'Réponse à la question :',
                'required' => false,
                'attr' => ['class' => 'form-control', 'rows' => 8]
            ]);
        }



    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'user_roles' => [],
        ]);
    }
}