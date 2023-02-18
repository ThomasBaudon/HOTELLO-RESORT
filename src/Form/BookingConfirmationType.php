<?php

namespace App\Form;

use App\Entity\BookingConfirmation;
use App\Entity\Room;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class BookingConfirmationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('start_date', DateType::class, [
            //     'label' => false,
            //     'widget' => 'single_text',
            //     'input' => 'datetime_immutable',
            //     'attr' => ['hidden' => true],
            // ])
            // ->add('end_date', DateType::class, [
            //     'label' => false,
            //     'widget' => 'single_text',
            //     'input' => 'datetime_immutable',
            //     'attr' => ['hidden' => true],
            // ])
            // ->add('created_at', DateType::class, [
            //     'label' => false,
            //     'widget' => 'single_text',
            //     'input' => 'datetime_immutable',
            //     'attr' => ['hidden' => true],
            // ])
            // // ->add('booking_status', BooleanType::class, [
            // //     'label' => 'Statut de la réservation',
            // //     'attr' => ['hidden' => true],
            // // ])
            // ->add('adults_cap', IntegerType::class, [
            //     'label' => false,
            //     'attr' => ['hidden' => true],
            // ])
            // ->add('children_cap', IntegerType::class, [
            //     'label' => false,
            //     'attr' => ['hidden' => true],
            // ])
            // ->add('total_cost', IntegerType::class, [
            //     'label' => false,
            //     'attr' => ['hidden' => true],
            // ])
            // // ->add('room', CollectionType::class, [
            // //     'label' => false,
            // //     'data' => $options['data']['room_id'],
            // //     'data_class' => null,
            // //     // dd($options['data']['room_id']),
            // //     // 'data_class' => $options['data']['room_id'] ?? null,
            // //     // 'data_class' => Room::class ?? null,
            // //     'attr' => ['hidden' => true],
            // // ])
            // ->add('user', IntegerType::class, [
            //     'label' => false,
            //     'attr' => ['hidden' => true],
            // ])
            // add submit button
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => ['class' => 'btn btn-gold'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookingConfirmation::class,
        ]);
    }
}
