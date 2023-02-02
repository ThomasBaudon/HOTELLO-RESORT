<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        /* lastname */
        ->add('lastname_user', TextType::class, [
            'required' => true,
            'constraints'=>
                [
                    new NotBlank(['message' => 'Champs obligatoire']),
                    new Length([
                        'min' => 4,
                        'max' => 50,
                        'minMessage' => 'Votre nom doit contenir {{ limit }} caractères minimum.',
                        'maxMessage' => 'Votre nom ne doit pas contenir plus de {{ limit }} caractères.'
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z- ]+$/',
                        'message' => 'Ce champ ne peut contenir que des lettres'
                    ])
                    
                ]
        ])
        
        /* firstname */
        ->add('firstname_user', TextType::class, [
            'required' => true,
            'constraints'=>
                [
                    new NotBlank(['message' => 'Champs obligatoire']),
                    new Length([
                        'min' => 4,
                        'max' => 50,
                        'minMessage' => 'Votre prénom doit contenir {{ limit }} caractères minimum.',
                        'maxMessage' => 'Votre prénom ne doit pas contenir plus de {{ limit }} caractères.'
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Ce champ ne peut contenir que des lettres'
                    ])
                    
                ]
        ])

        /* phone */
        ->add('phone_user', TextType::class, [
            'required' => true,
            'constraints'=>
                [
                    new NotBlank(['message' => 'Champs obligatoire']),
                    new Length([
                        'min' => 10,
                        'max' => 12,
                        'minMessage' => 'Votre numéro de téléphone doit contenir {{ limit }} caractères minimum.',
                        'maxMessage' => 'Votre numéro de téléphone ne doit pas contenir plus de {{ limit }} caractères.'
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9]+$/',
                        'message' => 'Ce champ ne peut contenir que des chiffres'
                    ])
                ]
        ])

        /* email */
        ->add('email', EmailType::class, [
            'required' => true,
            'constraints'=>
                [
                    new NotBlank(['message' => 'Champs obligatoire']),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/',
                        'message' => 'Votre email n\'est pas valide'
                    ])
                    
                ]
        ])

        /* password */
        ->add('plainPassword', PasswordType::class, [
            'required' => true,
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'mapped' => false,
            'attr'   => ['autocomplete' => 'new-password'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Merci de saisir un mot de passe',
                ]),
                new Length([
                    'min' => 6,
                    // max length allowed by Symfony for security reasons
                    'max' => 30,
                    'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                    'maxMessage' => 'Votre mot de passe ne peut pas contenir plus de {{ limit }} caractères',
                ]),
            ],
        ])

        /* adress */
        ->add('adress_user', TextType::class, [
            'required' => true,
            'constraints'=>
                [
                    new NotBlank(['message' => 'Champs obligatoire']),
                    new Length([
                        'min' => 4,
                        'max' => 150,
                        'minMessage' => 'Votre adresse doit contenir {{ limit }} caractères minimum.',
                        'maxMessage' => 'Votre adresse ne doit pas contenir plus de {{ limit }} caractères.'
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9\/\s #,.-]+$/i',
                        'message' => 'Ce champ ne doit pas contenir de caractères spéciaux'
                    ])
                    
                ]
        ])

        /* city */
        ->add('city_user', TextType::class, [
            'required' => true,
            'constraints'=>
                [
                    new NotBlank(['message' => 'Champs obligatoire']),
                    new Length([
                        'min' => 3,
                        'max' => 50,
                        'minMessage' => 'Votre localité doit contenir {{ limit }} caractères minimum.',
                        'maxMessage' => 'Votre localité ne doit pas contenir plus de {{ limit }} caractères.'
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z- ]+$/',
                        'message' => 'Ce champ ne peut contenir que des lettres'
                    ])
                    
                ]
        ])

        /* zip */
        ->add('zip_user', TextType::class, [
            'required' => true,
            'constraints'=>
                [
                    new NotBlank(['message' => 'Champs obligatoire']),
                    new Length([
                        'min' => 3,
                        'max' => 10,
                        'minMessage' => 'Votre code postal doit contenir {{ limit }} caractères minimum.',
                        'maxMessage' => 'Votre code postal ne doit pas contenir plus de {{ limit }} caractères.'
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9]+$/',
                        'message' => 'Ce champ ne peut contenir que des chiffres'
                    ])
                    
                ]
        ])

        /* Birthdate */
        ->add('birthdate_user', DateType::class, [
            'required' => true,
            'label' => 'Votre date de naissance',
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd',
            'input'  => 'datetime_immutable',
            'placeholder' => [
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
            ],
        ])

        /* country */
        ->add('country_user', TextType::class, [
            'required' => true,
            'constraints'=>
                [
                    new NotBlank(['message' => 'Champs obligatoire']),
                    new Length([
                        'min' => 3,
                        'max' => 10,
                        'minMessage' => 'Votre pays doit contenir {{ limit }} caractères minimum.',
                        'maxMessage' => 'Votre pays ne doit pas contenir plus de {{ limit }} caractères.'
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z- ]+$/',
                        'message' => 'Ce champ ne peut contenir que des lettres'
                    ])
                    
                ]
        ])
        
        /* agreeTerms */
        ->add('agreeTerms', CheckboxType::class, [
            'required' => true,
            'mapped' => false,
            'label'  => 'J’accepte les termes et conditions d’utilisation.',
            'constraints' => [
                new IsTrue([
                    'message' => 'J’accepte les termes et conditions d’utilisation.',
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
