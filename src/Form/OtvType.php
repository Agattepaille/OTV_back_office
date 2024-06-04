<?php

namespace App\Form;

use App\Entity\OTV;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OtvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_Date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Start Date',
            ])
            ->add('end_Date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'End Date',
            ])
            ->add('mobilePhone', TelType::class, [
                'label' => 'Mobile Phone',
            ])
            ->add('landlinePhone', TelType::class, [
                'label' => 'Landline Phone',
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('data', TextareaType::class, [
                'label' => 'Data',
                'required' => false,
            ])
          /*   ->add('pathToFile', FileType::class, [
                'label' => 'Path to File',
                'required' => false,
            ])
            ->add('fileName', TextType::class, [
                'label' => 'File Name',
                'required' => false,
            ]) */
            ->add('comments', TextareaType::class, [
                'label' => 'Comments',
                'required' => false,
            ])
            ->add('status', TextType::class, [
                'label' => 'Status',
            ])
           /*  ->add('residents', null, [
                'label' => 'Residents',
            ])
            ->add('address', null, [
                'label' => 'Address',
            ])
            ->add('district', null, [
                'label' => 'District',
            ]) */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OTV::class,
        ]);
    }
}
