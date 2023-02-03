<?php

namespace App\Form;

use App\Entity\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname_contact', TextType::class, [
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
            ->add('firstname_contact', TextType::class, [
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
            ->add('email_contact', EmailType::class, [
                'constraints'=>
                    [
                        new NotBlank(['message' => 'Champs obligatoire']),
                        new Length([
                            'min' => 4,
                            'max' => 120,
                            'minMessage' => 'Votre email doit contenir {{ limit }} caractères minimum.',
                            'maxMessage' => 'Votre email ne doit pas contenir plus de {{ limit }} caractères.'
                        ]),
                        new Regex([
                            'pattern' => '/^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/',
                            'message' => 'Votre email n\'est pas valide'
                        ])
                        
                    ]
            ])
            ->add('phone_contact', TextType::class, [
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

            ->add('message_contact', TextareaType::class, [
                'constraints'=>
                    [
                        new NotBlank(['message' => 'Champs obligatoire']),
                        new Length([
                            'min' => 10,
                            'max' => 500,
                            'minMessage' => 'Votre message doit contenir {{ limit }} caractères minimum.',
                            'maxMessage' => 'Votre message ne doit pas contenir plus de {{ limit }} caractères.'
                        ]),
                        new Regex([
                            'pattern' => '/[\n\r\0]*(?=\w)(.*)/',
                            'message' => 'Votre message n\'est pas valide'
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
            'data_class' => Contact::class,
        ]);
    }
}
