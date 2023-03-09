<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
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
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'les champs du mot de passe doivent correspondre',
                'options' => [
                    'attr' => [
                        'class' => 'password-field'
                    ]
                ],
                "required" => true,
                'first_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Votre mot de passe...',
                        'class' => 'flex-1'
                    ],
                    "row_attr" => [
                        'class' => 'form-group flex'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Entrer un mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doi avoir au moins {{ limit }} caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096
                        ])
                    ]
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => ' Confirmer Votre mot de passe...',
                        'class' => 'flex-1'
                    ],
                    "row_attr" => [
                        'class' => 'form-group flex'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Entrer un mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doi avoir au moins {{ limit }} caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096
                        ])
                    ]
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
