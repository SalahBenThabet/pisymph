<?php

namespace App\Form;

use App\Entity\Typespace;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TypespaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('typeespace',TypeTextType::class,[
            'label'=>'Type Espace',
            'required' => false,
            'attr'=>[
                'placeholder'=>'merci de definir le type espace',
                'class' =>'typeespace'
            ],
            'constraints' => [
                new NotBlank(['message' => 'Type Espace est obligatoire.']),
            ]  
        ])
    ;
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Typespace::class,
        ]);
    }
}
