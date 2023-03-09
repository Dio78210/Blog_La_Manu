<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('full_name', TextType::class, [
            "label" => false,
            "attr" => [
                "placeholder" => "Votre nom et prénom ...",
                "class" => "flex-1"
            ],
            "row_attr" => [
                "class" => "form-group flex"
            ],
            "required" => true,
            ])
        ->add('email', EmailType::class, [
            "label" => false,
            "attr" => [
                "placeholder" => "Votre email ...",
                "class" => "flex-1"
            ],
            "row_attr" => [
                "class" => "form-group flex"
            ],
            "required" => true,
        ])
        ->add('password',PasswordType::class, [
            // 'hash_property_path' => 'password',
            // 'mapped' => false,
            "label" => false,
            "attr" => [
                "placeholder" => "Votre mot de passe ...",
                "class" => "flex-1"
            ],
            "row_attr" => [
                "class" => "form-group flex"
            ],
            "required" => true
        ])
        ->add('send', SubmitType::class, [
            "label" => "Send Message",
            "attr" => [
                "class" => "btn"
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
