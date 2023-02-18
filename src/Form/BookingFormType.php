<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class BookingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_date', DateType::class, [
                'label' => 'Arrivée',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'data' => new \DateTimeImmutable('now'),
                'constraints'=>
                [
                    new NotBlank(['message' => 'Champs obligatoire']),
                    new GreaterThanOrEqual([
                        'value' =>(new \DateTimeImmutable('now'))->format('Y-m-d'),
                        'message' => 'La date d\'arrivée doit être supérieure à la date du jour'
                        ])
                ]
            ])
                
            ->add('end_date', DateType::class, [
                'label' => 'Départ',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'data' => new \DateTimeImmutable('now + 1 day'),
                'constraints'=>
                [
                    new GreaterThan([
                        'value' => (new \DateTimeImmutable('now'))->format('Y-m-d'),
                        'message' => 'La date de départ doit être supérieure à la date d\'arrivée'
                    ])
                ]
            ])
            ->add('adults_cap', ChoiceType::class, [
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                ],
                'attr' => ['class' => 'select'],
                'label' => 'Adulte(s)',
                'constraints'=>
                    [
                        new NotBlank(['message' => 'Champs obligatoire']),
                        new Length([
                            'min' => 1,
                            'max' => 3,
                            'minMessage' => 'Votre nombre d\'adultes doit contenir {{ limit }} caractères minimum.',
                            'maxMessage' => 'Votre nombre d\'adultes ne doit pas contenir plus de {{ limit }} caractères.'
                        ]),
                        new Regex([
                            'pattern' => '/^[0-9]+$/',
                            'message' => 'Ce champ ne peut contenir que des chiffres'
                        ])
                    ]
            ])
            ->add('children_cap', ChoiceType::class, [
                'choices' => [
                    '0' => 0,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                ],
                'label' => 'Enfant(s)',
                'attr' => ['class' => 'select'],
                'constraints'=>
                    [
                        new NotBlank(['message' => 'Champs obligatoire']),
                        new Length([
                            'min' => 0,
                            'max' => 4,
                            'minMessage' => 'Votre nombre d\'enfants doit contenir {{ limit }} caractères minimum.',
                            'maxMessage' => 'Votre nombre d\'enfants ne doit pas contenir plus de {{ limit }} caractères.'
                        ]),
                        new Regex([
                            'pattern' => '/^[0-9]+$/',
                            'message' => 'Ce champ ne peut contenir que des chiffres'
                        ])
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false,
            'data_class' => Booking::class,
        ]);
    }
}


