<?php

namespace App\Form;

use App\Entity\Cars;
use App\Entity\Category;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class Cars1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category',EntityType::class,[
                'class'=>Category::class,
                'choice_label'=>'title',
            ])
            ->add('title')
            ->add('keywords')
            ->add('description')
            ->add('image',FileType::class,[
                'label'=>'Hotel Main Image',
                'mapped'=> false,
                'required'=>false,
                'constraints'=>[
                    new File([
                        'maxSize'=>'1024k',
                        'mimeTypes'=>[
                            'image/*',
                        ],
                        'mimeTypesMessage'=>'Please upload a valid Image File',
                    ])
                ],
            ])
            ->add('phone')
            ->add('fax')
            ->add('email')
            ->add('city', ChoiceType::class, array(
                'choices'=> array(
                    'Istanbul'=>'Istanbul',
                    'Ankara'=>'Ankara',
                    'Antalya'=>'Antalya',
                    'Paris'=>'Paris',
                    'Moscow'=>'Moscow',
                    'Barcelona'=>'Barcelona')
            ))
            ->add('country', ChoiceType::class,[
                    'choices'=>[
                        'Turkiye'=>'Turkiye',
                        'Spain'=>'Spain',
                        'Greece'=>'Greece',
                        'Russia'=>'Russia',
                        'France'=>'France'],
                ]
            )
            ->add('location')

            ->add('detail',CKEditorType::class,array(
                'config'=> [
                    'uiColor'=> '#ffffff' ,
                ],))
            ->add('created_at')
            ->add('updated_at')
            ->add('category')
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cars::class,
        ]);
    }
}
