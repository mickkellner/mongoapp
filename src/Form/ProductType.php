<?php

namespace App\Form;

use App\Document\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class)
                ->add('cover', FileType::class, [
                    'label' => 'Coverbild hochladen',
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [ new File([
                        'maxSize' => '5120k',
                            'mimeTypes' => [
                                'images/jpg',
                                'images/jpeg',
                            ],
                            'mimeTypesMessage' => 'Please upload a valid Picture',     
                        ])
                    ],
                ])
                ->add('price', TextType::class, ['label' => 'Preis'])
                ->add('submit', SubmitType::class, ['label' => 'Produkt anlegen'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
