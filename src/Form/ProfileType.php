<?php

namespace App\Form;

use App\Document\Profile;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('firstname', TextType::class, ['label' => 'Vorname'])
                ->add('lastname', TextType::class, ['label' => 'Nachname'])
                ->add('second_email', EmailType::class, ['label' => '2. Email Adresse'])
                ->add('submit', SubmitType::class, ['label' => 'Profil speichern'])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data' => Profile::class,
        ]);
    }
}
