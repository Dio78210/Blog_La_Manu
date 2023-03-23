<?php

namespace App\Form;

use App\Entity\About;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AboutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title',TextType::class,[
            "label" => false,
        "attr" => [
            "placeholder" => "About title ...",
            "class" => "flex-1"
        ],
        "row_attr" => [
            "class" => "form-group flex"
        ]
        ])
        ->add('content',TextareaType::class,[
            'label'=>false,
            'required'=>false,
            'attr'=>[
                'placeholder'=>'About content...',
                'class'=>'flex-1',
                'rows'=>15
            ],
            'row_attr'=>[
                'class'=>'form-group flex'
            ]
        ])
        ->add('imageFile', FileType::class,[
            'label'=>false,
            'attr'=>[
                'class'=>'flex-1'
            ],
            'row_attr'=>[
                'class'=>'form-group flex'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => About::class,
        ]);
    }
}
