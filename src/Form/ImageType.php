<?php

namespace App\Form;

use App\Entity\Cars;
use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('vehicle')
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
                'class'=> Cars::class,
                'choice_label'=>'title',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Image::class,
            'csrf_protection'=> false,
        ));
    }
}
