<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;




class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('email')
            ->add('LastName', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ Nom est obligatoire.']),
                    new Regex(['pattern' => '/^[a-zA-Z]+$/i', 'message' => 'Le champ Nom ne doit contenir que des lettres.']),
                ],
            ])
            ->add('FirstName', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ Prénom est obligatoire.']),
                    new Regex(['pattern' => '/^[a-zA-Z]+$/i', 'message' => 'Le champ Prénom ne doit contenir que des lettres.']),
                ],
            ])
            ->add('Birthday', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'constraints' => [
                    new NotBlank(['message' => 'Le champ Date de naissance est obligatoire.']),
                ],
            ])
            ->add('CIN', IntegerType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ CIN est obligatoire.']),
                    new Regex(['pattern' => '/^\d{8}$/', 'message' => 'Le champ CIN doit contenir exactement 8 chiffres.']),
                ],
            ])
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'homme',
                    'Femme' => 'femme',
                ],
                'expanded' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Le champ Sexe est obligatoire.']),
                    new Choice(['choices' => ['homme', 'femme'], 'message' => 'Le champ Sexe doit être Homme ou Femme.']),
                ],
            ])
            ->add('Num_Tel', IntegerType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ Numéro est obligatoire.']),
                    new Regex(['pattern' => '/^\d{8}$/', 'message' => 'Le champ Numéro doit contenir exactement 8 chiffres.']),
                ],
            ])
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'Visiteur' => 'visiteur',
                    'Artiste' => 'artiste',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le champ Rôle est obligatoire.']),
                    new Choice(['choices' => ['visiteur', 'artiste'], 'message' => 'Le champ Rôle doit être Visiteur ou Artiste.']),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
