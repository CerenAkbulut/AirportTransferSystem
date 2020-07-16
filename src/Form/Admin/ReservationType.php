<?php

namespace App\Form\Admin;

use App\Entity\Admin\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userid')
            ->add('carsid')
            ->add('vehicleid')
            ->add('name')
            ->add('surname')
            ->add('email')
            ->add('phone')
            ->add('fromdest')
            ->add('todest')
            ->add('total')
            ->add('ip')
            ->add('message')
            ->add('note')
            ->add('status')
            ->add('created_at')
            ->add('updated_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
