<?php

namespace App\Form;

use App\Entity\Residents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResidentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('civility')
            ->add('lastname')
            ->add('firstname')
            ->add('mobilePhone')
            ->add('landlinePhone')
            ->add('email')
            ->add('street')
            ->add('streetNumber')
            ->add('additionalStreetNumber')
            ->add('additionalAddressInfo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Residents::class,
        ]);
    }
}
