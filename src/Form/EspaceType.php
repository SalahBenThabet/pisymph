<?php

namespace App\Form;

use App\Entity\Espace;
use App\Entity\Typespace;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType as TypeIntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class EspaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('capacite', TypeIntegerType::class, [
                'label' => 'capacite',
                'required' => false,
                'attr' => [
                    'placeholder' => 'merci de definir le capacite',
                    'class' => 'capacite'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'La capacité est obligatoire.']),
                    new Positive(['message' => 'La capacité doit être positive.'])
                ]
            ])
            ->add('nom', TextType::class, [
                'label' => 'nom',
                'required' => false,
                'attr' => [
                    'placeholder' => 'merci de definir le nom',
                    'class' => 'nom'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le nom est obligatoire.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Le nom ne doit pas dépasser {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('adresse', TextType::class, [
                'label' => 'adresse',
                'required' => false,
                'attr' => [
                    'placeholder' => 'merci de definir le adresse',
                    'class' => 'adresse'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'L\'adresse est obligatoire.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'L\'adresse ne doit pas dépasser {{ limit }} caractères.'
                    ])
                ]
            ])
            
                ->add('etat', ChoiceType::class, [
                    'label' => 'Etat',
                    'required' => false,
                    'choices' => [
                        'Disponible' => 'Disponible',
                        'Non Disponible' => 'Non Disponible'
                        
                ],
                'constraints' => [
                    new NotBlank(['message' => 'L\'état est obligatoire.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'L\'état ne doit pas dépasser {{ limit }} caractères.'
                    ])
                ]
            ])
           ->add('IdType', EntityType::class, [
                'class' => Typespace::class,
                'choice_label' => 'typeespace',
                'required' => false,
                'label' => 'Type d\'espace',
                'constraints' => [
                    new NotBlank(['message' => 'Le type d\'espace est obligatoire.'])
                ]
           ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Espace::class,
        ]);
    }
}
