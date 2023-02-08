<?php

namespace App\Form;

use App\Entity\Newsletter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NewsletterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'attr' => [
                'placeholder' => 'Votre adresse email'
            ],
            'label' => 'Votre email',
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
        // ->add('submit', SubmitType::class, [
        //     'label' => 'Je m\'inscris',
        //     'attr' => [
        //         'class' => 'btn btn-gold'
        //     ]
        // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Newsletter::class,
        ]);
    }
}
