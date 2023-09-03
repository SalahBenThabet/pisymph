<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Reponse;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TypeTextType::class, [
                'label' => 'titre',
                'required' => false,
                'attr' => [ 
                    'placeholder' => 'Saisir le titre ...',
                    'class' => 'titre'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Titre obligatoire.']),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'Le titre ne doit pas dépasser {{ limit }} caractères.'
                    ])
                     ]
            ])
            ->add('description', TypeTextType::class, [
                'label' => 'description',
                'required' => false,
                'attr' => [ 
                    'placeholder' => 'Description ...',
                    'class' => 'titre'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'La description est obligatoire.']),
                    new Length([
                        'max' => 1000,
                        'maxMessage' => 'La description ne doit pas dépasser {{ limit }} caractères.'
                    ])
                     ]
            ])
            ->add('IdRec',EntityType::class, [
                'class' => Reclamation::class,
                'choice_label' => 'description', ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reponse::class,
        ]);
    }
}
