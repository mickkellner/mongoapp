<?php
namespace App\Form\Type;

use App\Document\Product;
use App\Form\EventListener\AddNameFieldSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class, )
                ->add('cover', FileType::class, [
                      'label' => 'Coverbild hochladen',
                      'mapped' => false,
                      'required' => false,
                      'constraints' => [ new File(['maxSize' => '5120k' ])                       
                    ],
                ])
                ->add('price', TextType::class, ['label' => 'Preis'])
                ->add('submit', SubmitType::class, ['label' => 'Produkt anlegen'])
        ;
        $builder->addEventSubscriber(new AddNameFieldSubscriber());
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $product = $event->getData();
            $form = $event->getForm();
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
