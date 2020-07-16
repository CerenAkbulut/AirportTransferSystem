<?php

namespace App\Form\Admin;

use App\Entity\Admin\Vehicles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiclesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')

            ->add('description')
            ->add('image',FileType::class,['label'=>'Cars Gallery Image',
                'mapped'=>false,
                'required'=>false,
                'constraints'=>[
                    new File(
                        [
                            'maxSize'=>'4096k',
                            'mimeTypes'=>[
                                'image/*',
                            ],
                            'mimeTypesMessage'=>'Please upload a valid Image File'
                        ]
                    )
                ],])
            ->add('cars', EntityType::class,[
                'class'=> Hotel::class,
                'choice_label'=>'title',
            ])
            ->add('price')
            ->add('status',ChoiceType::class,[
                'choices'=>[
                    'True'=>True,
                    'False'=>False,
                ]
            ])
            ->add('numberofvehicles')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicles::class,
        ]);
    }
}
